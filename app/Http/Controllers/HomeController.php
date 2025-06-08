<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::get();
        $categories = Category::get();
        $promotion = Promotion::where('key', 'home')->get()[0];
        
        return view('home', compact('categories', 'products', 'promotion'));
    }

    public function contact()
    {
        return view('contact');
    }
}