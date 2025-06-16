<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Promotion;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::with('products')->get();
        
        $query = Product::with('category');
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('deskripsi_singkat', 'like', "%{$search}%")
                  ->orWhere('deskripsi_panjang', 'like', "%{$search}%");
            });
        }
        
        $products = $query->get();
        $promotion = Promotion::where('key', 'home')->first();
        
        return view('product', compact('categories', 'products', 'promotion'));
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
        $promotion = Promotion::where('key', 'home')->first();
        
        return view('product-category', compact('category', 'sub_categories', 'promotion'));
    }

}