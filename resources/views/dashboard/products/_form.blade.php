@if ($errors->any())
    <div class="alert alert-danger">
        <h3>Error Occured!</h3>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="form-group">
    <x-form.input label="Product Name" class="form-control-lg" role="input" name="name" :value="$product->name" />
</div>
<div class="form-group">
    <label for="">Description</label>
    <x-form.textarea name="description" :value="$product->description" />
</div>
<div class="form-group">
    <x-form.input label="Price" class="form-control-lg" role="input" name="price" :value="$product->price" />
</div>
<div class="form-group">
    <x-form.input label="Quantity" class="form-control-lg" role="input" name="quantity" :value="$product->quantity" />
</div>
<div class="form-group">
    <label for="">Image</label>
    <input type="file" name="image" class="form-control" accept="image/*">
    @if ($product->image)
        <img src="{{ asset('storage/' . $product->image) }}" alt="" height="50">
    @endif
</div>
<div class="form-group">
    <div class="form-check">
        <input class="form-check-input" type="radio" name="status" value="active" @checked($product->status == 'active')>
        <label class="form-check-label">
            Active
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="status" value="archived" @checked($product->status == 'draft')>
        <label class="form-check-label" for="exampleRadios2">
            Draft
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="status" value="archived" @checked($product->status == 'archived')>
        <label class="form-check-label" for="exampleRadios2">
            Archived
        </label>
    </div>
</div>
<div class="mt-4 form-group">
    <label for="" class="mb-2">Categories</label>
    <div class="row">
        @foreach ($categories as $index => $category)
            @if ($index % 5 === 0 && $index !== 0)
    </div>
    <div class="row">
        @endif
        <div class="col-md-2">
            <div class="form-check">
                <input name="categories_ids[]" class="form-check-input" type="checkbox" \
                    @if (in_array($category->id, $product->categories->pluck('id')->toArray()))  checked @endif id="{{ $category->name }}"
                    value="{{ $category->id }}">
                <label class="form-check-label" for="{{ $category->name }}">
                    {{ $category->name }}
                </label>
            </div>
        </div>
        @endforeach
    </div>
</div>
<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ $button_label ?? 'Save' }}</button>
</div>
