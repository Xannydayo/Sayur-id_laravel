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
                                <p class="font-medium">Total Jumlah Pembayaran:</p>
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
                             @if ($order->courier)
                            <div>
                                <p class="font-medium">Biaya Pengiriman ({{ $order->courier }}):</p>
                                <p class="text-lg">Rp {{ number_format($order->getCourierPrice(), 0, ',', '.') }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <form method="POST" action="{{ route('payments.store') }}" class="space-y-8">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $order->id }}">

                        <!-- Payment Method -->
                        <div>
                            <x-input-label for="payment_method" :value="__('Pilih Metode Pembayaran')" class="text-lg font-medium mb-4" />
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label for="payment_bank_transfer" class="flex items-center p-4 bg-gray-100 dark:bg-gray-700 rounded-lg shadow-md cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200">
                                    <input type="radio" id="payment_bank_transfer" name="payment_method" value="bank_transfer" class="form-radio h-5 w-5 text-green-600" required>
                                    <div class="ml-4">
                                        <i class="fas fa-bank fa-2x text-blue-500 dark:text-blue-400 mb-2"></i>
                                        <span class="text-lg font-semibold text-gray-800 dark:text-gray-100 block">Transfer Bank</span>
                                        <span class="text-sm text-gray-600 dark:text-gray-300">BCA, Mandiri, BNI, BRI</span>
                                    </div>
                                </label>

                                <label for="payment_e_wallet" class="flex items-center p-4 bg-gray-100 dark:bg-gray-700 rounded-lg shadow-md cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200">
                                    <input type="radio" id="payment_e_wallet" name="payment_method" value="e_wallet" class="form-radio h-5 w-5 text-green-600" required>
                                    <div class="ml-4">
                                        <i class="fas fa-wallet fa-2x text-purple-500 dark:text-purple-400 mb-2"></i>
                                        <span class="text-lg font-semibold text-gray-800 dark:text-gray-100 block">E-Wallet</span>
                                        <span class="text-sm text-gray-600 dark:text-gray-300">GoPay, OVO, DANA, LinkAja</span>
                                    </div>
                                </label>

                                <label for="payment_cash" class="flex items-center p-4 bg-gray-100 dark:bg-gray-700 rounded-lg shadow-md cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200">
                                    <input type="radio" id="payment_cash" name="payment_method" value="cash" class="form-radio h-5 w-5 text-green-600" required>
                                    <div class="ml-4">
                                        <i class="fas fa-money-bill-wave fa-2x text-yellow-600 dark:text-yellow-500 mb-2"></i>
                                        <span class="text-lg font-semibold text-gray-800 dark:text-gray-100 block">Cash on Delivery</span>
                                        <span class="text-sm text-gray-600 dark:text-gray-300">Bayar di tempat saat barang sampai</span>
                                    </div>
                                </label>

                                <label for="payment_qris" class="flex items-center p-4 bg-gray-100 dark:bg-gray-700 rounded-lg shadow-md cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200">
                                    <input type="radio" id="payment_qris" name="payment_method" value="qris" class="form-radio h-5 w-5 text-green-600" required>
                                    <div class="ml-4">
                                        <i class="fas fa-qrcode fa-2x text-red-500 dark:text-red-400 mb-2"></i>
                                        <span class="text-lg font-semibold text-gray-800 dark:text-gray-100 block">QRIS</span>
                                        <span class="text-sm text-gray-600 dark:text-gray-300">Scan QR Code untuk pembayaran instan</span>
                                    </div>
                                </label>
                            </div>
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
                            <x-primary-button type="submit" class="ml-4 px-8 py-3 bg-green-600 hover:bg-green-700 focus:bg-green-700 active:bg-green-800 text-white font-bold rounded-full shadow-lg transition duration-300 ease-in-out transform hover:scale-105">
                                {{ __('Konfirmasi Pembayaran') }} <i class="fas fa-check-circle ml-2"></i>
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 