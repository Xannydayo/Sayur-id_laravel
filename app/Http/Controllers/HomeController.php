<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::get();
        $categories = Category::get();
        $promotion = Promotion::where('key', 'home')->first();
        
        $wishlistedProductIds = [];
        if (Auth::check()) {
            $wishlistedProductIds = Auth::user()->wishlists->pluck('product_id')->toArray();
        }

        return view('home', compact('categories', 'products', 'promotion', 'wishlistedProductIds'));
    }

    public function contact()
    {
        return view('contact');
    }
}