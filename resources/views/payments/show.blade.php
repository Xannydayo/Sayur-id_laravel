<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Payment Receipt #') . $payment->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">Payment Details</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="font-semibold">Payment ID:</p>
                            <p>{{ $payment->id }}</p>
                        </div>
                        <div>
                            <p class="font-semibold">Order Number:</p>
                            <p>{{ $payment->order->order_number }}</p>
                        </div>
                        <div>
                            <p class="font-semibold">Amount Paid:</p>
                            <p>Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="font-semibold">Payment Method:</p>
                            <p>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</p>
                        </div>
                        <div>
                            <p class="font-semibold">Status:</p>
                            <p>{{ ucfirst($payment->status) }}</p>
                        </div>
                        <div>
                            <p class="font-semibold">Payment Date:</p>
                            <p>{{ $payment->created_at->format('d M Y H:i') }}</p>
                        </div>
                        @if ($payment->payment_details)
                            <div class="col-span-2">
                                <p class="font-semibold">Payment Details:</p>
                                <p>{{ $payment->payment_details }}</p>
                            </div>
                        @endif
                    </div>

                    <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium mb-4">Order Summary</h3>
                        @php
                            $product_total = 0;
                            foreach ($payment->order->products as $product) {
                                $product_total += $product->pivot->quantity * $product->pivot->price;
                            }
                            $shipping_cost = $payment->order->getCourierPrice();
                        @endphp
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="font-semibold">Product Total:</p>
                                <p>Rp {{ number_format($product_total, 0, ',', '.') }}</p>
                            </div>
                            @if ($payment->order->courier)
                                <div>
                                    <p class="font-semibold">Shipping ({{ $payment->order->courier }}):</p>
                                    <p>Rp {{ number_format($shipping_cost, 0, ',', '.') }}</p>
                                </div>
                            @endif
                            <div class="col-span-2">
                                <p class="font-semibold text-xl">Grand Total:</p>
                                <p class="text-xl">Rp {{ number_format($payment->order->total_amount, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-4">
                        <a href="{{ route('orders.show', $payment->order) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            View Order Details
                        </a>
                        <a href="{{ route('payments.receipt.pdf', $payment) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-green-600 dark:bg-green-400 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-900 uppercase tracking-widest hover:bg-green-700 dark:hover:bg-green-500 focus:bg-green-700 dark:focus:bg-green-500 active:bg-green-900 dark:active:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Cetak Struk PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 