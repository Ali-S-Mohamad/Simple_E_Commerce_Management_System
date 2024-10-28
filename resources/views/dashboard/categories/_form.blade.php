
@if($errors->any())
<div class="alert alert-danger">
    <h3>Error Occured!</h3>
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="form-group">
    <x-form.input label="Category Name" class="form-control-lg" role="input" name="name" :value="$category->name" />
</div>
<div class="form-group">
    <label for="">Description</label>
    <x-form.textarea name="description" :value="$category->description" />
</div>
<div class="form-group">
    <label for="">Image</label>
    <input type="file" name="image" class="form-control" accept="image/*">
    @if ($category->image)
        <img src="{{ asset('storage/' . $category->image) }}" alt="" height="50">
    @endif
</div>
<div class="form-group">
    <div class="form-check">
        <input class="form-check-input" type="radio" name="status" value="active" @checked($category->status == 'active')>
        <label class="form-check-label">
            Active
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="status" value="archived" @checked($category->status == 'archived')>
        <label class="form-check-label" for="exampleRadios2">
            Archived
        </label>
    </div>
</div>
<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ $button_label ?? 'Save'}}</button>
</div>
