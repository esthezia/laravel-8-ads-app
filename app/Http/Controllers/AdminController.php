<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Session;
use App\Models\User;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\City;
use App\Models\Ad;

class AdminController extends Controller
{
    private $defaultStringColumnLength = 0;

    public function __construct() {
        $this->defaultStringColumnLength = \Illuminate\Database\Schema\Builder::$defaultStringLength;

        // the parent has no constructor
        // parent::__construct();
    }

    public function index() {
        return view('admin.index');
    }

    public function ads() {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect('admin');
        }

        $ads = Ad::with(['category', 'subcategory', 'city'])->get()->toArray();

        return view('admin.ads', [
            'ads' => $ads
        ]);
    }

    public function adsCreate(Request $request) {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect('admin');
        }

        $categories = Category::all()->toArray();
        $subcategories = Subcategory::all()->toArray();
        $cities = City::all()->toArray();

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'title' => 'required|max:' . $this->defaultStringColumnLength,
                'description' => 'required',
                'type' => 'required|in:free,premium',
                'id_category' => 'required|exists:categories,id',
                'id_subcategory' => 'required|exists:subcategories,id',
                'id_city' => 'required|exists:cities,id',
                'image' => 'image|max:' . getMaxFileUploadSizeInBytes('2M') / 1024 // max has to be in kilobytes
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $validatedData = $validator->validated();

            if ($request->file()) {
                $fileName = date('YmdHis') . '_' . getSlugFromName($validatedData['title']) . '.' . $request->image->extension();
                $filePath = $request->file('image')->storeAs('/ads', $fileName, 'public');
            }

            $ad = new Ad;
            $ad->title = $validatedData['title'];
            $ad->description = $validatedData['description'];
            $ad->type = $validatedData['type'];
            $ad->id_category = (int) $validatedData['id_category'];
            $ad->id_subcategory = (int) $validatedData['id_subcategory'];
            $ad->id_city = (int) $validatedData['id_city'];
            $ad->image = !empty($fileName) ? $fileName : null;

            if ($ad->save()) {
                Session::flash('success-message', 'The ad was saved successfully!');
            } else {
                Session::flash('error-message', 'There was an error while saving the ad. Please try again later. If the error persists, please contact us.');
            }

            return redirect()->route('admin.ads');
        }

        return view('admin.ads-create', [
            'categories' => $categories,
            'subcategories' => $subcategories,
            'cities' => $cities
        ]);
    }

    public function categories() {
        $categories = Category::all()->toArray();

        return view('admin.categories', [
            'categories' => $categories
        ]);
    }

    public function categoriesCreate(Request $request, Category $category = null) {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:' . $this->defaultStringColumnLength,
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            if (empty($category)) {
                $category = new Category;
            }

            $category->name = $validator->validated()['name'];

            if ($category->save()) {
                Session::flash('success-message', 'The category was saved successfully!');
            } else {
                Session::flash('error-message', 'There was an error while saving the category. Please try again later. If the error persists, please contact us.');
            }

            return redirect()->route('admin.categories');
        }

        return view('admin.categories-create', [
            'category' => $category
        ]);
    }

    public function subcategories() {
        $subcategories = Subcategory::with('category')->get()->toArray();

        return view('admin.subcategories', [
            'subcategories' => $subcategories
        ]);
    }

    public function subcategoriesCreate(Request $request, Subcategory $subcategory = null) {
        $categories = Category::all()->toArray();

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'id_category' => 'required|exists:categories,id',
                'name' => 'required|max:' . $this->defaultStringColumnLength,
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            if (empty($subcategory)) {
                $subcategory = new Subcategory;
            }

            $subcategory->id_category = (int) $validator->validated()['id_category'];
            $subcategory->name = $validator->validated()['name'];

            if ($subcategory->save()) {
                Session::flash('success-message', 'The subcategory was saved successfully!');
            } else {
                Session::flash('error-message', 'There was an error while saving the subcategory. Please try again later. If the error persists, please contact us.');
            }

            return redirect()->route('admin.subcategories');
        }

        return view('admin.subcategories-create', [
            'categories' => $categories,
            'subcategory' => $subcategory
        ]);
    }

    public function cities() {
        $cities = City::all()->toArray();

        return view('admin.cities', [
            'cities' => $cities
        ]);
    }

    public function citiesCreate(Request $request, City $city = null) {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:' . $this->defaultStringColumnLength,
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            if (empty($city)) {
                $city = new City;
            }

            $city->name = $validator->validated()['name'];

            if ($city->save()) {
                Session::flash('success-message', 'The city was saved successfully!');
            } else {
                Session::flash('error-message', 'There was an error while saving the city. Please try again later. If the error persists, please contact us.');
            }

            return redirect()->route('admin.cities');
        }

        return view('admin.cities-create', [
            'city' => $city
        ]);
    }

    /**
     * This is only for admin users
     */
    public function deleteEntity(Request $request, $entityType, $id) {
        if (empty($entityType) || empty($id)) {
            Session::flash('error-message', 'Invalid request.');

            return redirect()->route('admin');
        }

        switch ($entityType) {
            case 'category':
                if (Category::find((int) $id)->delete() === true) {
                    Session::flash('success-message', 'The category was deleted successfully!');
                } else {
                    Session::flash('error-message', 'There was an error while deleting the category. Please try again later. If the error persists, please contact us.');
                }

                return redirect()->route('admin.categories');
                break;
            case 'subcategory':
                if (Subcategory::find((int) $id)->delete() === true) {
                    Session::flash('success-message', 'The subcategory was deleted successfully!');
                } else {
                    Session::flash('error-message', 'There was an error while deleting the subcategory. Please try again later. If the error persists, please contact us.');
                }

                return redirect()->route('admin.subcategories');
                break;
            case 'city':
                if (City::find((int) $id)->delete() === true) {
                    Session::flash('success-message', 'The city was deleted successfully!');
                } else {
                    Session::flash('error-message', 'There was an error while deleting the city. Please try again later. If the error persists, please contact us.');
                }

                return redirect()->route('admin.cities');
                break;
            default:
                Session::flash('error-message', 'Invalid request.');

                return redirect()->route('admin');
                break;
        }

        exit();
    }
}
