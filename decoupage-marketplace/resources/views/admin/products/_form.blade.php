@csrf
@if($product->exists)
    @method('PUT')
@endif
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $product->title) }}" required>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="category_id">Category</label>
            <select name="category_id" id="category_id" class="form-control" required>
                @foreach($categories as $id => $label)
                    <option value="{{ $id }}" @selected(old('category_id', $product->category_id) == $id)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
                @foreach(['draft' => 'Draft', 'active' => 'Active', 'archived' => 'Archived'] as $value => $label)
                    <option value="{{ $value }}" @selected(old('status', $product->status ?? 'active') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="slug">Slug</label>
            <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $product->slug) }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="sku">SKU</label>
            <input type="text" name="sku" id="sku" class="form-control" value="{{ old('sku', $product->sku) }}">
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" step="0.01" name="price" id="price" class="form-control" value="{{ old('price', $product->price) }}" required>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label for="stock">Stock</label>
            <input type="number" name="stock" id="stock" class="form-control" value="{{ old('stock', $product->stock) }}" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="thumbnail">Thumbnail URL</label>
            <input type="url" name="thumbnail" id="thumbnail" class="form-control" value="{{ old('thumbnail', $product->thumbnail) }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="images">Gallery image URLs (one per line)</label>
            <textarea name="images" id="images" rows="3" class="form-control">{{ old('images', is_array($product->images) ? implode(PHP_EOL, $product->images) : '') }}</textarea>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="short_description">Short description</label>
            <textarea name="short_description" id="short_description" rows="2" class="form-control">{{ old('short_description', $product->short_description) }}</textarea>
        </div>
        <div class="form-check mt-2">
            <input type="checkbox" name="is_featured" value="1" id="is_featured" class="form-check-input" @checked(old('is_featured', $product->is_featured))>
            <label for="is_featured" class="form-check-label">Featured on storefront</label>
        </div>
    </div>
    <div class="col-md-8">
        <div class="form-group">
            <label for="description">Full description</label>
            <textarea name="description" id="description" rows="5" class="form-control">{{ old('description', $product->description) }}</textarea>
        </div>
    </div>
</div>
