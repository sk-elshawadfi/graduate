@csrf
@if($recycleRequest->exists)
    @method('PUT')
@endif
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="user_id">User</label>
            <select name="user_id" id="user_id" class="form-control" required>
                @foreach($users as $id => $name)
                    <option value="{{ $id }}" @selected(old('user_id', $recycleRequest->user_id) == $id)>{{ $name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="request_type">Type</label>
            <select name="request_type" id="request_type" class="form-control">
                @foreach(['recycle' => 'Recycle', 'sell' => 'Sell'] as $value => $label)
                    <option value="{{ $value }}" @selected(old('request_type', $recycleRequest->request_type) === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
                @foreach(['pending','reviewing','approved','rejected','completed'] as $status)
                    <option value="{{ $status }}" @selected(old('status', $recycleRequest->status) === $status)>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="admin_price">Admin price (EGP)</label>
            <input type="number" step="0.01" name="admin_price" id="admin_price" class="form-control" value="{{ old('admin_price', $recycleRequest->admin_price) }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="image">Upload image</label>
            <input type="file" name="image" id="image" class="form-control">
            @if($recycleRequest->image_path)
                <small class="text-muted d-block mt-1">Current: {{ $recycleRequest->image_path }}</small>
            @endif
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" rows="4" class="form-control">{{ old('description', $recycleRequest->description) }}</textarea>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label for="feedback">Feedback / Notes</label>
            <textarea name="feedback" id="feedback" rows="3" class="form-control">{{ old('feedback', $recycleRequest->feedback) }}</textarea>
        </div>
    </div>
</div>
