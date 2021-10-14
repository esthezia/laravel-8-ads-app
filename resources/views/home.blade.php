@extends('layout')

@section('content')
<p>Filter by:</p>
<form method="get" action="" class="row mb-3" autocomplete="off">
    <div class="col-md-3 pb5">
        <label for="ad-id-category" class="form-label">Category</label>
        <select name="category" id="ad-id-category" class="form-control" autofocus>
            <option value=""></option>
            @foreach ($categories as $category)
            <option value="{{ (int) $category['id'] }}"<?php echo (int) $category['id'] === $categorySelected ? ' selected="selected"' : ''; ?>>{{ $category['name'] }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <label for="ad-id-subcategory" class="form-label">Subcategory</label>
        <select name="subcategory" id="ad-id-subcategory" class="form-control">
            <option value=""></option>
            @foreach ($subcategories as $subcategory)
            <option value="{{ (int) $subcategory['id'] }}" data-category="{{ (int) $subcategory['id_category'] }}"<?php echo (int) $subcategory['id'] === $subcategorySelected ? ' selected="selected"' : ''; ?>>{{ $subcategory['name'] }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <label for="ad-id-city" class="form-label">City</label>
        <select name="city" id="ad-id-city" class="form-control">
            <option value=""></option>
            @foreach ($cities as $city)
            <option value="{{ (int) $city['id'] }}"<?php echo (int) $city['id'] === $citySelected ? ' selected="selected"' : ''; ?>>{{ $city['name'] }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <button type="submit" class="btn btn-primary mt33">Filter</button>
    </div>
</form>

@if (empty($ads))
    <p>There are no ads to show.</p>
@else

    <ul class="list-group list-group-flush">
        @foreach ($ads as $ad)
        <li class="list-group-item">
            <?php
                echo '<h5 class="mb-1">' . htmlspecialchars($ad['title']) . '</h5>';

                if (!empty($ad['image'])) {
                    echo '<img src="' . asset('media/ads/' . $ad['image']) . '" alt="" height="50" class="float-start" />';
                }

                $descriptionStripped = strip_tags($ad['description']);

                echo '<p class="m0">' . (strlen($descriptionStripped) > 50 ? substr($descriptionStripped, 0, 50) . '...' : $descriptionStripped) . '</p>';
                echo '<small class="txt-small text-muted">' . htmlspecialchars($ad['category']['name']) . ', ' . htmlspecialchars($ad['subcategory']['name']) . ', ' . htmlspecialchars($ad['city']['name']) . '</small><br />';
            ?>
        </li>
        @endforeach
    </ul>
@endif
@endsection
