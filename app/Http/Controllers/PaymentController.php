<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('payment.index', compact('order'));
    }

    public function process(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'payment_method' => 'required|in:balance,bank_transfer,credit_card',
        ]);

        if ($request->payment_method === 'balance') {
            $user = Auth::user();
            
            if ($user->balance < $order->total_amount) {
                return back()->with('error', 'Insufficient balance');
            }

            // Deduct balance
            $user->balance -= $order->total_amount;
            $user->save();

            // Update order status
            $order->payment_method = 'balance';
            $order->payment_status = 'paid';
            $order->status = 'processing';
            $order->save();

            return redirect()->route('orders.show', $order)->with('success', 'Payment successful using balance');
        }

        // Handle other payment methods
        // ... existing code for other payment methods ...
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