@csrf
@if($category->exists)
    @method('PUT')
@endif
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $category->name) }}" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="slug">Slug</label>
            <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $category->slug) }}">
        </div>
    </div>
    <div class="col-md-8">
        <div class="form-group">
            <label for="image_url">Image URL</label>
            <input type="url" name="image_url" id="image_url" class="form-control" value="{{ old('image_url', $category->image_url) }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="display_order">Display order</label>
            <input type="number" name="display_order" id="display_order" class="form-control" value="{{ old('display_order', $category->display_order) }}">
        </div>
        <div class="form-check mt-4">
            <input type="checkbox" name="is_featured" value="1" id="is_featured" class="form-check-input" @checked(old('is_featured', $category->is_featured))>
            <label for="is_featured" class="form-check-label">Featured category</label>
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" rows="3" class="form-control">{{ old('description', $category->description) }}</textarea>
        </div>
    </div>
</div>
