<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Promotion;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    public function index()
    {
        $categories = Category::with('products')->get();
        $products = Product::with('category')->get();
        $promotion = Promotion::where('key', 'home')->get()[0];
        return view('product', compact('categories', 'products'));
    }

    public function show($slug)
    {
        $product = Product::with('category')->where('slug', $slug)->firstOrFail();
        $similar_products = Product::where('category_id', $product->category_id)->where('id','!=', $product->id)->get();
        return view('product-detail', compact('product', 'similar_products'));
    }

    public function category(Category $category)
    {
        $sub_categories = Category::with('products')->get();
        $promotion = Promotion::where('key', 'home')->get()[0];
        
        return view('product-category', compact('category','sub_categories'));
    }

}