@extends('layout')

@section('content')
<h1 class="h3 mb-4">Create / edit subcategory</h1>

@if ($errors->any())
<div class="alert alert-danger">
    @foreach ($errors->all() as $error)
        {{ $error }}<br />
    @endforeach
</div>
@endif

<div class="row">
    <div class="col-md-6">
        <form method="post" action="{{ route('admin.subcategories-create', $subcategory ? $subcategory->id : null) }}" autocomplete="off">
            @csrf

            <div class="form-group mb-3">
                <label for="subcategory-id-category" class="form-label">Category</label>
                <select name="id_category" id="subcategory-id-category" class="form-control" required="required" autofocus>
                    <option value=""></option>
                    @foreach ($categories as $category)
                    <option value="{{ (int) $category['id'] }}"<?php echo $subcategory && ((int) $subcategory['id_category'] === (int) $category['id']) ? ' selected="selected"' : ''; ?>>{{ $category['name'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="subcategory-name" class="form-label">Name</label>
                <input type="text" name="name" value="{{ $subcategory ? $subcategory->name : '' }}" id="subcategory-name" class="form-control" required="required">
            </div>

            <button type="submit" class="btn btn-success">Save</button>
        </form>
    </div>
</div>
@endsection
