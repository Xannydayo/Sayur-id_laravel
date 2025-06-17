<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product ? $item->product->harga * $item->quantity : 0;
        });

        $couriers = [
            ['code' => 'jne', 'name' => 'JNE', 'cost' => 15000],
            ['code' => 'jnt', 'name' => 'J&T', 'cost' => 18000],
            ['code' => 'sicepat', 'name' => 'SiCepat', 'cost' => 20000],
        ];

        return view('checkout.index', compact('cartItems', 'subtotal', 'couriers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
            'alamat' => 'required|string',
            'telepon' => 'required|string',
            'kurir' => 'required|string',
            'coupon_code' => 'nullable|string',
        ]);

        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product ? $item->product->harga * $item->quantity : 0;
        });

        // Hitung diskon jika ada kupon
        $discountAmount = 0;
        $coupon = null;
        if ($request->coupon_code) {
            $coupon = Coupon::where('code', $request->coupon_code)->first();
            if ($coupon && $coupon->isValid()) {
                $discountAmount = $coupon->calculateDiscount($subtotal);
            }
        }

        // Hitung biaya pengiriman
        $shippingCost = 0;
        $couriers = [
            ['code' => 'jne', 'name' => 'JNE', 'cost' => 15000],
            ['code' => 'jnt', 'name' => 'J&T', 'cost' => 18000],
            ['code' => 'sicepat', 'name' => 'SiCepat', 'cost' => 20000],
        ];
        
        foreach ($couriers as $courier) {
            if ($courier['code'] === $request->kurir) {
                $shippingCost = $courier['cost'];
                break;
            }
        }

        // Generate order number
        $orderNumber = 'ORD-' . time() . '-' . strtoupper(uniqid());

        $order = Order::create([
            'user_id' => Auth::id(),
            'order_number' => $orderNumber,
            'shipping_address' => $request->alamat,
            'shipping_phone' => $request->telepon,
            'courier' => $request->kurir,
            'subtotal' => $subtotal,
            'shipping_cost' => $shippingCost,
            'discount_amount' => $discountAmount,
            'total_amount' => $subtotal + $shippingCost - $discountAmount,
            'coupon_code' => $request->coupon_code,
            'status' => 'pending',
        ]);

        foreach ($cartItems as $item) {
            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->harga,
            ]);
        }

        // Update jumlah penggunaan kupon jika ada
        if ($coupon) {
            $coupon->increment('used_count');
        }

        // Clear the cart
        Cart::where('user_id', Auth::id())->delete();

        // Redirect to payment page
        return redirect()->route('payment', ['order' => $order->id])
            ->with('success', 'Pesanan berhasil dibuat. Silakan lanjutkan ke pembayaran.');
    }
} 