@extends('layout')

@section('content')
<h1 class="h3 mb-4">Create ad</h1>

@if ($errors->any())
<div class="alert alert-danger">
    @foreach ($errors->all() as $error)
        {{ $error }}<br />
    @endforeach
</div>
@endif

<div class="row">
    <div class="col-md-6">
        <form method="post" action="{{ route('admin.ads-create') }}" enctype="multipart/form-data" autocomplete="off">
            @csrf

            <div class="form-group mb-3">
                <label for="ad-id-category" class="form-label">Category</label>
                <select name="id_category" id="ad-id-category" class="form-control" required="required" autofocus>
                    <option value=""></option>
                    @foreach ($categories as $category)
                    <option value="{{ (int) $category['id'] }}"<?php echo (int) $category['id'] === (int) old('id_category') ? ' selected="selected"' : ''; ?>>{{ $category['name'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="ad-id-subcategory" class="form-label">Subcategory</label>
                <select name="id_subcategory" id="ad-id-subcategory" class="form-control" required="required">
                    <option value=""></option>
                    @foreach ($subcategories as $subcategory)
                    <option value="{{ (int) $subcategory['id'] }}" data-category="{{ (int) $subcategory['id_category'] }}"<?php echo (int) $subcategory['id'] === (int) old('id_subcategory') ? ' selected="selected"' : ''; ?>>{{ $subcategory['name'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="ad-id-city" class="form-label">City</label>
                <select name="id_city" id="ad-id-city" class="form-control" required="required">
                    <option value=""></option>
                    @foreach ($cities as $city)
                    <option value="{{ (int) $city['id'] }}"<?php echo (int) $city['id'] === (int) old('id_city') ? ' selected="selected"' : ''; ?>>{{ $city['name'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="ad-title" class="form-label">Title</label>
                <input type="text" name="title" id="ad-title" class="form-control" required="required" value="{{ old('title') }}">
            </div>
            <div class="form-group mb-3">
                <label for="ad-description" class="form-label">Description</label>
                <textarea name="description" id="ad-description" cols="30" rows="5" class="form-control">{{ old('description') }}</textarea>
            </div>
            <div class="form-group mb-3">
                <p class="form-label">Type</p>
                <div class="form-check form-check-inline">
                    <input type="radio" name="type" id="ad-type-free" value="free" class="form-check-input"<?php echo empty(old('type')) || (old('type') === 'free') ? ' checked="checked"' : ''; ?>>
                    <label class="form-check-label" for="ad-type-free">free</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" name="type" id="ad-type-premium" value="premium" class="form-check-input"<?php echo old('type') === 'premium' ? ' checked="checked"' : ''; ?>>
                    <label class="form-check-label" for="ad-type-premium">premium</label>
                </div>
            </div>
            <div class="form-group mb-5">
                <label for="ad-image" class="form-label">Image <small>(max. file size {{ getMaxFileUploadSizeInBytes('2M') / (1024 * 1024) }}MB)</small></label>
                <input type="file" name="image" class="form-control" accept="image/*" />
            </div>

            <button type="submit" class="btn btn-success">Save</button>
        </form>
    </div>
</div>
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
@endsection
