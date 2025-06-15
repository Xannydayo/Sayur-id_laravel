<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    public function create(Order $order)
    {
        return view('payments.create', compact('order'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'payment_method' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'payment_details' => 'nullable|string',
        ]);

        $order = Order::findOrFail($validated['order_id']);

        $payment = Payment::create([
            'order_id' => $order->id,
            'payment_method' => $validated['payment_method'],
            'amount' => $validated['amount'],
            'transaction_id' => null, // Tidak ada transaction ID dari gateway
            'status' => 'paid', // Langsung set paid untuk pembayaran manual
            'payment_details' => $validated['payment_details'],
        ]);

        $order->update(['status' => 'processing']); // Perbarui status order menjadi processing setelah pembayaran

        // Temporarily dump and die to inspect variables
        // dd($payment, $order);

        return redirect()->route('orders.index')
            ->with('success', 'Pembayaran berhasil diproses secara manual.');
    }

    public function show(Payment $payment)
    {
        // Load order and its products/user relationship for the receipt
        $payment->load('order.products', 'order.user');
        return view('payments.show', compact('payment'));
    }

    public function generateReceiptPdf(Payment $payment)
    {
        // Load order and its products/user relationship for the receipt
        $payment->load('order.products', 'order.user');

        $pdf = Pdf::loadView('payments.receipt-pdf', compact('payment'));
        return $pdf->download('receipt-' . $payment->id . '.pdf');
    }
}