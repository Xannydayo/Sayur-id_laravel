<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
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
        $orders = auth()->user()->orders()->latest()->get();
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
            ]);

            $product = Product::findOrFail($validated['product_id']);
            $total_amount = $product->harga * $validated['quantity'];

            // Add courier price to total amount if a courier is selected
            if (isset($validated['courier']) && array_key_exists($validated['courier'], Order::COURIER_PRICES)) {
                $total_amount += Order::COURIER_PRICES[$validated['courier']];
            }

            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => 'ORD-' . Str::random(10),
                'total_amount' => $total_amount,
                'status' => 'pending',
                'shipping_address' => $validated['shipping_address'],
                'shipping_phone' => $validated['shipping_phone'],
                'notes' => $validated['notes'],
                'courier' => $validated['courier'] ?? null,
            ]);

            // Attach product to order with quantity and price
            $order->products()->attach($product->id, [
                'quantity' => $validated['quantity'],
                'price' => $product->harga
            ]);

            // Redirect to payment creation page after successful order creation
            return redirect()->route('payments.create', $order)
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
}