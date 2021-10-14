@extends('layout')

@section('content')
<h1 class="h3 mb-4">Ads</h1>

@if (Session::has('success-message'))
<p class="alert alert-success">{{ Session::get('success-message') }}</p>
@endif

<a href="{{ route('admin.ads-create') }}" class="btn btn-secondary">Create ad</a>

@if (empty($ads))
    <p class="py-4">There are no ads.</p>
@else
    <div class="table-responsive py-4">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Image</th>
                    <th scope="col">Title</th>
                    <th scope="col">Type</th>
                    <th scope="col">City</th>
                    <th scope="col">Category</th>
                    <th scope="col">Subcategory</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ads as $ad)
                <tr>
                    <td>{{ (int) $ad['id'] }}</td>
                    <td><?php echo !empty($ad['image']) ? '<img src="' . asset('media/ads/' . $ad['image']) . '" alt="" height="30" />' : '-'; ?></td>
                    <td>{{ $ad['title'] }}</td>
                    <td>{{ $ad['type'] }}</td>
                    <td>{{ !empty($ad['city']['name']) ? $ad['city']['name'] : '-' }}</td>
                    <td>{{ !empty($ad['category']['name']) ? $ad['category']['name'] : '-' }}</td>
                    <td>{{ !empty($ad['subcategory']['name']) ? $ad['subcategory']['name'] : '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <small class="text-muted">{{ count($ads) }} record<?php echo count($ads) !== 1 ? 's' : ''; ?></small>
    </div>
@endif
@endsection
