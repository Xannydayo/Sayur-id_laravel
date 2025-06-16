<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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

        // Add sorting logic
        $sortBy = $request->get('sort_by', 'terbaru'); // Default to 'terbaru'

        switch ($sortBy) {
            case 'nama_asc':
                $query->orderBy('nama', 'asc');
                break;
            case 'nama_desc':
                $query->orderBy('nama', 'desc');
                break;
            case 'harga_asc':
                $query->orderBy('harga', 'asc');
                break;
            case 'harga_desc':
                $query->orderBy('harga', 'desc');
                break;
            case 'terbaru':
            default:
                $query->latest(); // Order by created_at DESC
                break;
        }
        
        $products = $query->get();
        $promotion = Promotion::where('key', 'home')->first();

        $wishlistedProductIds = [];
        if (Auth::check()) {
            $wishlistedProductIds = Auth::user()->wishlists->pluck('product_id')->toArray();
        }
        
        return view('product', compact('categories', 'products', 'promotion', 'sortBy', 'wishlistedProductIds'));
    }

    public function show($slug)
    {
        $product = Product::with('category')->where('slug', $slug)->firstOrFail();
        $similar_products = Product::where('category_id', $product->category_id)->where('id','!=', $product->id)->get();

        $isWishlisted = false;
        if (Auth::check()) {
            $isWishlisted = Auth::user()->wishlists()->where('product_id', $product->id)->exists();
        }

        return view('product-detail', compact('product', 'similar_products', 'isWishlisted'));
    }

    public function category(Category $category)
    {
        $sub_categories = Category::with('products')->get();
        $promotion = Promotion::where('key', 'home')->first();
        
        return view('product-category', compact('category', 'sub_categories', 'promotion'));
    }

}