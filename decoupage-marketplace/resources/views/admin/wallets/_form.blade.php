@csrf
@if($wallet->exists)
    @method('PUT')
@endif
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="user_id">User</label>
            <select name="user_id" id="user_id" class="form-control" required>
                @foreach($users as $id => $name)
                    <option value="{{ $id }}" @selected(old('user_id', $wallet->user_id) == $id)>{{ $name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="balance">Balance</label>
            <input type="number" name="balance" id="balance" class="form-control" step="0.01" value="{{ old('balance', $wallet->balance) }}" required>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="currency">Currency</label>
            <input type="text" name="currency" id="currency" class="form-control text-uppercase" value="{{ old('currency', $wallet->currency ?? 'EGP') }}" maxlength="3" required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="active" @selected(old('status', $wallet->status ?? 'active') === 'active')>Active</option>
                <option value="suspended" @selected(old('status', $wallet->status) === 'suspended')>Suspended</option>
            </select>
        </div>
    </div>
</div>
