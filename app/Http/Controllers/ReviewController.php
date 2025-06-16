<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        // Debug: Dump the entire request to see all incoming data
        // dd($request->all());

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'order_id' => 'required|exists:orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Debug: Dump validated data
        // dd($validated);

        $product = Product::findOrFail($validated['product_id']);
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Debug: Dump user object and try to access orders
        // dd($user, $user->orders()->get());

        $order = $user->orders()->where('id', $validated['order_id'])->first();

        // Debug: Dump order object
        // dd($order);

        if (!$order || $order->status !== 'completed' || !$order->products->contains($product->id)) {
            // Debug: If this condition is met, dump a message
            // dd('Validation failed: Order not found, not completed, or product not in order.');
            return redirect()->back()->with('error', 'Anda tidak diizinkan memberikan ulasan untuk produk ini pada pesanan ini.');
        }

        // Ensure the user hasn't already reviewed this product for this order
        $existingReview = Review::where('user_id', $user->id)
                                ->where('product_id', $validated['product_id'])
                                ->where('order_id', $validated['order_id'])
                                ->first();

        // Debug: Dump existing review status
        // dd('Existing Review:', $existingReview);

        if ($existingReview) {
            return redirect()->back()->with('error', 'Anda sudah mengulas produk ini untuk pesanan ini.');
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('reviews', 'public');
        }

        Review::create([
            'user_id' => $user->id,
            'product_id' => $validated['product_id'],
            'order_id' => $validated['order_id'],
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'image' => $imagePath,
        ]);

        // Debug: Dump success message before redirect
        // dd('Review created successfully!');

        return redirect()->route('product.show', $product->slug)->with('success', 'Ulasan Anda berhasil ditambahkan!');
    }
}