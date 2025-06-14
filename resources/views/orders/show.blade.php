<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Order Details #') . $order->order_number }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">Order Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="font-semibold">Order Number:</p>
                            <p>{{ $order->order_number }}</p>
                        </div>
                        <div>
                            <p class="font-semibold">Total Amount:</p>
                            <p>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="font-semibold">Status:</p>
                            <p>{{ ucfirst($order->status) }}</p>
                        </div>
                        <div>
                            <p class="font-semibold">Shipping Address:</p>
                            <p>{{ $order->shipping_address }}</p>
                        </div>
                        <div>
                            <p class="font-semibold">Phone Number:</p>
                            <p>{{ $order->shipping_phone }}</p>
                        </div>
                        <div>
                            <p class="font-semibold">Courier:</p>
                            <p>{{ $order->courier ?? '-' }}</p>
                        </div>
                        @if ($order->notes)
                            <div>
                                <p class="font-semibold">Notes:</p>
                                <p>{{ $order->notes }}</p>
                            </div>
                        @endif
                        <div>
                            <p class="font-semibold">Order Date:</p>
                            <p>{{ $order->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg font-medium mb-4">Products in Order</h3>
                        @if ($order->products->count() > 0)
                            <ul class="list-disc list-inside">
                                @foreach ($order->products as $product)
                                    <li>{{ $product->pivot->quantity }} x {{ $product->name }} @ Rp {{ number_format($product->pivot->price, 0, ',', '.') }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>No products found for this order.</p>
                        @endif
                    </div>

                    <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium mb-4">Order Summary</h3>
                        @php
                            $product_total = 0;
                            foreach ($order->products as $product) {
                                $product_total += $product->pivot->quantity * $product->pivot->price;
                            }
                            $shipping_cost = $order->getCourierPrice();
                        @endphp
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="font-semibold">Product Total:</p>
                                <p>Rp {{ number_format($product_total, 0, ',', '.') }}</p>
                            </div>
                            @if ($order->courier)
                                <div>
                                    <p class="font-semibold">Shipping ({{ $order->courier }}):</p>
                                    <p>Rp {{ number_format($shipping_cost, 0, ',', '.') }}</p>
                                </div>
                            @endif
                            <div class="col-span-2">
                                <p class="font-semibold text-xl">Grand Total:</p>
                                <p class="text-xl">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-4">
                        <a href="{{ route('orders.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Back to Orders
                        </a>
                        @if ($order->status === 'pending' && !$order->payment)
                            <a href="{{ route('payments.create', $order) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-400 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-900 uppercase tracking-widest hover:bg-blue-700 dark:hover:bg-blue-500 focus:bg-blue-700 dark:focus:bg-blue-500 active:bg-blue-900 dark:active:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Bayar Sekarang
                            </a>
                        @endif
                        @if ($order->payment)
                        <a href="{{ route('payments.receipt.pdf', $order->payment) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-green-600 dark:bg-green-400 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-900 uppercase tracking-widest hover:bg-green-700 dark:hover:bg-green-500 focus:bg-green-700 dark:focus:bg-green-500 active:bg-green-900 dark:active:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Cetak Struk PDF
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 