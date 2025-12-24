@csrf
@if($user->exists)
    @method('PUT')
@endif
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="name">Full name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="password">Password {{ $user->exists ? '(leave blank to keep current)' : '' }}</label>
            <input type="password" name="password" id="password" class="form-control" {{ $user->exists ? '' : 'required' }}>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $user->address) }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="city">City</label>
            <input type="text" name="city" id="city" class="form-control" value="{{ old('city', $user->city) }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="country">Country</label>
            <input type="text" name="country" id="country" class="form-control" value="{{ old('country', $user->country) }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="postal_code">Postal code</label>
            <input type="text" name="postal_code" id="postal_code" class="form-control" value="{{ old('postal_code', $user->postal_code) }}">
        </div>
    </div>
    <div class="col-md-9">
        <div class="form-group">
            <label for="bio">Bio</label>
            <textarea name="bio" id="bio" rows="3" class="form-control">{{ old('bio', $user->bio) }}</textarea>
        </div>
    </div>
    <div class="col-md-3">
        @if(count($roleOptions) > 1)
            <div class="form-group">
                <label for="role">Role</label>
                <select name="role" id="role" class="form-control">
                    @foreach($roleOptions as $value => $label)
                        <option value="{{ $value }}" @selected(old('role', $user->roles->pluck('name')->first()) === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        @else
            <input type="hidden" name="role" value="user">
        @endif
        <div class="form-check mt-4">
            <input type="checkbox" name="is_banned" value="1" id="is_banned" class="form-check-input" @checked(old('is_banned', $user->is_banned))>
            <label for="is_banned" class="form-check-label">Account is banned</label>
        </div>
    </div>
</div>
