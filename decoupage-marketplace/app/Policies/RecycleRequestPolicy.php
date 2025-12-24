<?php

namespace App\Policies;

use App\Models\RecycleRequest;
use App\Models\User;
use App\Policies\Concerns\HandlesAdminAuthorization;

class RecycleRequestPolicy
{
    use HandlesAdminAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $this->isAdmin($user);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, RecycleRequest $recycleRequest): bool
    {
        return $this->isAdmin($user) || $recycleRequest->user_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->isAdmin($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, RecycleRequest $recycleRequest): bool
    {
        return $this->isAdmin($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, RecycleRequest $recycleRequest): bool
    {
        return $this->isAdmin($user);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, RecycleRequest $recycleRequest): bool
    {
        return $this->isAdmin($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, RecycleRequest $recycleRequest): bool
    {
        return $user->isSuperAdmin();
    }
}
