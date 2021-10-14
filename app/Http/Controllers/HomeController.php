<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Ad;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\City;

class HomeController extends Controller
{
    public function index(Request $request) {
        $categories = Category::all()->toArray();
        $subcategories = Subcategory::with('category')->get()->toArray();
        $cities = City::all()->toArray();

        $categorySelected = (int) $request->get('category');
        $subcategorySelected = (int) $request->get('subcategory');
        $citySelected = (int) $request->get('city');

        $ads = Ad::with(['category', 'subcategory', 'city']);

        if (!empty($categorySelected)) {
            $ads->where('id_category', $categorySelected);
        }
        if (!empty($subcategorySelected)) {
            $ads->where('id_subcategory', $subcategorySelected);
        }
        if (!empty($citySelected)) {
            $ads->where('id_city', $citySelected);
        }

        $ads = $ads->get()->toArray();

        return view('home', [
            'ads' => $ads,
            'categories' => $categories,
            'subcategories' => $subcategories,
            'cities' => $cities,
            'categorySelected' => $categorySelected,
            'subcategorySelected' => $subcategorySelected,
            'citySelected' => $citySelected,
        ]);
    }
}
