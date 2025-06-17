<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Payment Confirmation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('payment.process', $order) }}" class="space-y-6">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $order->id }}">

                        <!-- Order Summary Section -->
                        <div class="mb-8 p-6 bg-gray-50 dark:bg-gray-700 rounded-xl shadow-md border border-gray-200 dark:border-gray-600">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-50 mb-3">Ringkasan Pesanan</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700 dark:text-gray-300">
                                <div>
                                    <p class="font-medium">Nomor Pesanan:</p>
                                    <p class="text-lg">#{{ $order->order_number }}</p>
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
                                @if ($order->shipping_cost > 0)
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

                        <div class="payment-methods">
                            <h3 class="text-lg font-semibold mb-4">Payment Methods</h3>
                            
                            <div class="space-y-4">
                                <!-- Balance Payment Option -->
                                <label for="balance" class="flex items-center p-4 bg-gray-100 dark:bg-gray-700 rounded-lg shadow-md cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200">
                                    <input type="radio" name="payment_method" id="balance" value="balance" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500" required>
                                    <div class="ml-4">
                                        <i class="fas fa-wallet fa-2x text-indigo-500 dark:text-indigo-400 mb-2"></i>
                                        <span class="text-lg font-semibold text-gray-800 dark:text-gray-100 block">Balance</span>
                                        <span class="text-sm text-gray-600 dark:text-gray-300">Available: Rp {{ number_format(auth()->user()->balance, 0, ',', '.') }}</span>
                                    </div>
                                </label>

                                <!-- You can add other payment methods here -->
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
                        </div>

                        @if(session('error'))
                            <div class="mt-4 p-4 bg-red-100 text-red-700 rounded-md">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="flex items-center justify-end mt-6">
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Confirm Payment
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>