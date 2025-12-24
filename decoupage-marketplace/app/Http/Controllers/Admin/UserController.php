<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct(private ActivityLogger $logger)
    {
        $this->authorizeResource(User::class, 'user');
    }

    public function index(Request $request): View
    {
        $query = User::query()->with('roles');

        if ($search = $request->string('search')->toString()) {
            $query->where(function ($builder) use ($search) {
                $builder
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($role = $request->string('role')->toString()) {
            $query->role($role);
        }

        if ($status = $request->string('status')->toString()) {
            $query->where('is_banned', $status === 'banned');
        }

        $users = $query->latest()->paginate(12)->withQueryString();

        return view('admin.users.index', [
            'users' => $users,
            'roleOptions' => $this->roleOptions(),
        ]);
    }

    public function create(): View
    {
        return view('admin.users.create', [
            'user' => new User(),
            'roleOptions' => $this->roleOptions(),
        ]);
    }

    public function store(UserRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $role = $this->resolveRole($data['role'] ?? 'user');
        $data['is_banned'] = $request->boolean('is_banned');
        unset($data['role']);

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user = User::create($data);
        $user->syncRoles([$role]);

        $this->logger->log('user.created', [
            'description' => 'Admin created a user',
            'subject_type' => User::class,
            'subject_id' => $user->id,
            'properties' => ['role' => $role],
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function show(User $user): View
    {
        $user->load(['wallet', 'orders' => fn ($query) => $query->latest()->limit(10)]);

        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', [
            'user' => $user,
            'roleOptions' => $this->roleOptions(),
        ]);
    }

    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();
        $role = $this->resolveRole($data['role'] ?? $user->roles->pluck('name')->first(), $user);
        $data['is_banned'] = $request->boolean('is_banned');
        unset($data['role']);

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);
        $user->syncRoles([$role]);

        $this->logger->log('user.updated', [
            'description' => 'Admin updated a user',
            'subject_type' => User::class,
            'subject_id' => $user->id,
            'properties' => ['role' => $role],
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        $this->logger->log('user.deleted', [
            'description' => 'Admin deleted a user',
            'subject_type' => User::class,
            'subject_id' => $user->id,
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User removed.');
    }

    public function ban(User $user): RedirectResponse
    {
        $this->authorize('update', $user);

        if (auth()->id() === $user->id) {
            return back()->with('error', 'You cannot ban your own account.');
        }

        $user->update(['is_banned' => true]);

        $this->logger->log('user.banned', [
            'description' => 'User banned from admin panel',
            'subject_type' => User::class,
            'subject_id' => $user->id,
        ]);

        return back()->with('success', 'User banned successfully.');
    }

    public function unban(User $user): RedirectResponse
    {
        $this->authorize('update', $user);

        $user->update(['is_banned' => false]);

        $this->logger->log('user.unbanned', [
            'description' => 'User unbanned from admin panel',
            'subject_type' => User::class,
            'subject_id' => $user->id,
        ]);

        return back()->with('success', 'User unbanned successfully.');
    }

    public function syncRoles(Request $request, User $user): RedirectResponse
    {
        $this->authorize('update', $user);

        $data = $request->validate([
            'role' => ['required', 'in:user,admin'],
        ]);

        $role = $this->resolveRole($data['role'], $user);
        $user->syncRoles([$role]);

        $this->logger->log('user.role.updated', [
            'description' => 'Admin updated user role',
            'subject_type' => User::class,
            'subject_id' => $user->id,
            'properties' => ['role' => $role],
        ]);

        return back()->with('success', 'Role updated.');
    }

    protected function roleOptions(): array
    {
        $options = ['user' => 'Customer'];

        if (auth()->user()?->isSuperAdmin()) {
            $options['admin'] = 'Administrator';
        }

        return $options;
    }

    protected function resolveRole(?string $role, ?User $user = null): string
    {
        $role = $role ?? 'user';

        if ($role === 'admin' && ! auth()->user()?->isSuperAdmin()) {
            return 'user';
        }

        if ($user?->isSuperAdmin()) {
            return 'super_admin';
        }

        return $role === 'admin' ? 'admin' : 'user';
    }
}
