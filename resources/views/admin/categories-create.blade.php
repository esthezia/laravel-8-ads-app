@extends('layout')

@section('content')
<h1 class="h3 mb-4">Create / edit category</h1>

@if ($errors->any())
<div class="alert alert-danger">
    @foreach ($errors->all() as $error)
        {{ $error }}<br />
    @endforeach
</div>
@endif

<div class="row">
    <div class="col-md-6">
        <form method="post" action="{{ route('admin.categories-create', $category ? $category->id : null) }}" autocomplete="off">
            @csrf

            <div class="form-group mb-3">
                <label for="category-name" class="form-label">Name</label>
                <input type="text" name="name" value="{{ $category ? $category->name : '' }}" id="category-name" class="form-control" required="required" autofocus>
            </div>

            <button type="submit" class="btn btn-success">Save</button>
        </form>
    </div>
</div>
@endsection
