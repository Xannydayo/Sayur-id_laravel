<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        $user = auth()->user();
        if (!$user instanceof User) {
            return redirect()->route('login');
        }
        $orders = $user->orders()->latest()->get();
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $product = null;
        if ($request->has('product_id')) {
            $product = Product::findOrFail($request->product_id);
        }
        return view('orders.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'shipping_address' => 'required|string',
                'shipping_phone' => 'required|string',
                'notes' => 'nullable|string',
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|numeric|min:1',
                'courier' => 'nullable|string',
                'coupon_code' => 'nullable|string',
            ]);

            $product = Product::findOrFail($validated['product_id']);
            $subtotal = $product->harga * $validated['quantity'];
            $shippingCost = 0;
            $discountAmount = 0;
            $coupon = null;

            // Calculate shipping cost
            if (isset($validated['courier']) && array_key_exists($validated['courier'], \App\Models\Order::COURIER_PRICES)) {
                $shippingCost = \App\Models\Order::COURIER_PRICES[$validated['courier']];
            }

            // Process coupon if exists
            if ($request->coupon_code) {
                $coupon = Coupon::where('code', $request->coupon_code)->first();
                if ($coupon && $coupon->isValid($subtotal)) {
                    $discountAmount = $coupon->calculateDiscount($subtotal);
                } else {
                    // If coupon is not valid, add error to session
                    return redirect()->back()->withErrors(['coupon_code' => 'Kode kupon tidak valid atau tidak bisa digunakan untuk pesanan ini.'])->withInput();
                }
            }

            $total_amount = $subtotal + $shippingCost - $discountAmount;

            $order = \App\Models\Order::create([
                'user_id' => auth()->id(),
                'order_number' => 'ORD-' . \Illuminate\Support\Str::random(10),
                'total_amount' => $total_amount,
                'status' => 'pending',
                'shipping_address' => $validated['shipping_address'],
                'shipping_phone' => $validated['shipping_phone'],
                'notes' => $validated['notes'],
                'courier' => $validated['courier'] ?? null,
                'subtotal' => $subtotal,
                'discount_amount' => $discountAmount,
                'shipping_cost' => $shippingCost,
                'coupon_code' => $coupon ? $coupon->code : null,
            ]);

            // Attach product to order with quantity and price
            $order->products()->attach($product->id, [
                'quantity' => $validated['quantity'],
                'price' => $product->harga
            ]);

            // Increment used_count of coupon if applied successfully
            if ($coupon && $discountAmount > 0) {
                $coupon->increment('used_count');
            }

            // Redirect to payment creation page after successful order creation
            return redirect()->route('payment', $order)
                ->with('success', 'Pesanan berhasil dibuat. Silakan lanjutkan ke pembayaran.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal membuat pesanan: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        return view('orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'shipping_address' => 'required|string',
            'shipping_phone' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $order->update($validated);

        return redirect()->route('orders.show', $order)
            ->with('success', 'Order updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('orders.index')
            ->with('success', 'Order cancelled successfully.');
    }

    /**
     * Confirm order completion by user
     */
    public function confirm(Order $order)
    {
        // Check if the order belongs to the authenticated user
        if ($order->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk mengkonfirmasi pesanan ini.');
        }

        // Check if the order is in processing status
        if ($order->status !== 'processing') {
            return redirect()->back()->with('error', 'Pesanan harus dalam status "processing" untuk dikonfirmasi.');
        }

        // Update order status to completed
        $order->update(['status' => 'completed']);

        return redirect()->route('orders.show', $order)
            ->with('success', 'Pesanan berhasil dikonfirmasi selesai.');
    }
}