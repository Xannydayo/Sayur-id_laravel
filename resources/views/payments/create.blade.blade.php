<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Konfirmasi Pembayaran untuk Pesanan #') . $order->order_number }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6 text-center">Detail Pembayaran</h3>

                    <div class="mb-8 p-6 bg-gray-50 dark:bg-gray-700 rounded-xl shadow-md border border-gray-200 dark:border-gray-600">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-50 mb-3">Ringkasan Pesanan</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700 dark:text-gray-300">
                            <div>
                                <p class="font-medium">Nomor Pesanan:</p>
                                <p class="text-lg">{{ $order->order_number }}</p>
                            </div>
                            <div>
                                <p class="font-medium">Subtotal:</p>
                                <p class="text-lg">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</p>
                            </div>
                            @if($order->discount_amount > 0)
                            <div>
                                <p class="font-medium">Diskon:</p>
                                <p class="text-lg text-green-600">- Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</p>
                                @if($order->coupon_code)
                                <p class="text-sm text-gray-500">Kupon: {{ $order->coupon_code }}</p>
                                @endif
                            </div>
                            @endif
                            @if($order->shipping_cost > 0)
                            <div>
                                <p class="font-medium">Biaya Pengiriman ({{ $order->courier }}):</p>
                                <p class="text-lg">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</p>
                            </div>
                            @endif
                            <div>
                                <p class="font-medium">Total Pembayaran:</p>
                                <p class="text-xl font-semibold text-green-700 dark:text-green-400">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="font-medium">Produk:</p>
                                <ul class="list-disc list-inside ml-4">
                                    @foreach($order->products as $product)
                                        <li>{{ $product->pivot->quantity }} kg {{ $product->nama }} (Rp {{ number_format($product->pivot->price, 0, ',', '.') }} / kg)</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('payments.store') }}" class="space-y-8">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $order->id }}">

                        <!-- Payment Method -->
                        <div>
                            <x-input-label for="payment_method" :value="__('Pilih Metode Pembayaran')" class="text-lg font-medium" />
                            <select id="payment_method" name="payment_method" class="mt-2 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 focus:ring-green-500 focus:border-green-500 rounded-lg shadow-sm" required>
                                <option value="">-- Pilih Metode Pembayaran --</option>
                                <option value="bank_transfer">Transfer Bank (BCA, Mandiri, BNI, BRI)</option>
                                <option value="e_wallet">E-Wallet (GoPay, OVO, DANA, LinkAja)</option>
                                <option value="qris">QRIS (Scan QR Code)</option>
                                <option value="cash">Cash on Delivery (Bayar di tempat)</option>
                                <option value="other">Lainnya</option>
                            </select>
                            <x-input-error :messages="$errors->get('payment_method')" class="mt-2" />
                        </div>

                        <!-- Amount -->
                        <div>
                            <x-input-label for="amount" :value="__('Jumlah Dibayar')" class="text-lg font-medium" />
                            <x-text-input id="amount" name="amount" type="number" step="0.01" class="mt-2 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-green-500 focus:border-green-500 dark:bg-gray-900 dark:text-gray-100" :value="old('amount', $order->total_amount)" required />
                            <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                        </div>

                        <!-- Payment Details -->
                        <div>
                            <x-input-label for="payment_details" :value="__('Detail Pembayaran (Opsional)')" class="text-lg font-medium" />
                            <textarea id="payment_details" name="payment_details" class="mt-2 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 focus:ring-green-500 focus:border-green-500 rounded-lg shadow-sm" rows="4" placeholder="Contoh: Melalui Bank BCA, atas nama [Nama Anda]">{{ old('payment_details') }}</textarea>
                            <x-input-error :messages="$errors->get('payment_details')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end">
                            <x-primary-button class="ml-4 px-8 py-3 bg-green-600 hover:bg-green-700 focus:bg-green-700 active:bg-green-800 text-white font-bold rounded-full shadow-lg transition duration-300 ease-in-out transform hover:scale-105">
                                {{ __('Konfirmasi Pembayaran') }} <i class="fas fa-check-circle ml-2"></i>
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 