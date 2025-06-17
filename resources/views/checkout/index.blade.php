@extends('layout')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-white text-3xl font-extrabold mb-8 text-center md:text-left">Checkout</h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Ringkasan Produk -->
        <div class="md:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 mb-6">
            <h2 class="text-2xl font-bold mb-6 text-green-600 flex items-center"><i class="fas fa-shopping-cart mr-3"></i>Produk di Keranjang</h2>
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($cartItems as $item)
                    <div class="flex flex-col md:flex-row items-center py-6 gap-6">
                        <img src="{{ asset('storage/' . $item->product->gambar) }}" alt="{{ $item->product->nama }}" class="w-24 h-24 object-cover rounded-xl shadow-md border border-gray-200 dark:border-gray-700">
                        <div class="flex-1 w-full">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between w-full">
                                <div>
                                    <div class="text-lg font-bold text-gray-900 dark:text-white mb-1">{{ $item->product->nama }}</div>
                                    <div class="text-gray-500 dark:text-gray-300 text-sm mb-2">Qty: <span class="font-semibold">{{ $item->quantity }}</span></div>
                                </div>
                                <div class="text-xl font-extrabold text-green-600 dark:text-green-400">Rp {{ number_format($item->product->harga * $item->quantity, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-500 py-8">Keranjang kosong.</div>
                @endforelse
            </div>
        </div>
        <!-- Ringkasan & Alamat -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 flex flex-col justify-between">
            <div>
                <h2 class="text-2xl font-bold mb-6 text-green-600 flex items-center"><i class="fas fa-receipt mr-3"></i>Ringkasan & Pembayaran</h2>
                @auth
                <form id="checkout-form" method="POST" action="{{ route('checkout.store') }}" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-gray-700 dark:text-gray-200 mb-2 font-semibold">Jumlah (kg)</label>
                        <input type="number" name="jumlah" min="1" value="{{ old('jumlah', $cartItems->sum('quantity')) }}" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 dark:bg-gray-700 dark:text-white" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 dark:text-gray-200 mb-2 font-semibold">Alamat Pengiriman Lengkap</label>
                        <input type="text" name="alamat" value="{{ old('alamat', Auth::user()->address ?? Auth::user()->alamat ?? Auth::user()->alamat_lengkap ?? '') }}" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 dark:bg-gray-700 dark:text-white" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 dark:text-gray-200 mb-2 font-semibold">Nomor Telepon (Aktif)</label>
                        <input type="text" name="telepon" value="{{ old('telepon', Auth::user()->phone ?? Auth::user()->no_hp ?? Auth::user()->nomor_telepon ?? '') }}" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 dark:bg-gray-700 dark:text-white" required>
                    </div>

                    <!-- Kode Kupon -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-200 mb-2 font-semibold">Kode Kupon (Opsional)</label>
                        <div class="flex gap-2">
                            <input type="text" name="coupon_code" id="coupon_code" value="{{ old('coupon_code') }}" class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 dark:bg-gray-700 dark:text-white" placeholder="Masukkan kode kupon">
                            <button type="button" onclick="applyCoupon()" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-300">Terapkan</button>
                        </div>
                        <div id="coupon_message" class="mt-2 text-sm"></div>
                    </div>

                    <div>
                        <label class="block text-gray-700 dark:text-gray-200 mb-2 font-semibold">Kurir Pengiriman</label>
                        <select name="kurir" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 dark:bg-gray-700 dark:text-white" required>
                            @foreach($couriers as $courier)
                                <option value="{{ $courier['code'] }}" data-cost="{{ $courier['cost'] }}">{{ $courier['name'] }} - Rp {{ number_format($courier['cost'], 0, ',', '.') }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Rincian Pembayaran -->
                    <div class="mt-6 space-y-3">
                        <div class="flex justify-between text-gray-600 dark:text-gray-400">
                            <span>Subtotal</span>
                            <span id="subtotal">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600 dark:text-gray-400">
                            <span>Biaya Pengiriman</span>
                            <span id="shipping_cost">Rp {{ number_format($couriers[0]['cost'], 0, ',', '.') }}</span>
                        </div>
                        <div id="discount_row" class="flex justify-between text-green-600 dark:text-green-400 hidden">
                            <span>Diskon</span>
                            <span id="discount_amount">- Rp 0</span>
                        </div>
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-3">
                            <div class="flex justify-between text-lg font-semibold text-gray-800 dark:text-white">
                                <span>Total</span>
                                <span id="total_amount">Rp {{ number_format($subtotal + $couriers[0]['cost'], 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-300">
                        Lanjut ke Pembayaran
                    </button>
                </form>
                @else
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded mb-4">
                    <p class="font-bold">Login Diperlukan</p>
                    <p>Anda harus <a href="{{ route('login') }}" class="underline text-green-600">login</a> untuk melakukan transaksi.</p>
                </div>
                <form class="space-y-6 opacity-50 pointer-events-none">
                    <input type="number" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg" placeholder="Jumlah (kg)" disabled>
                    <input type="text" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg" placeholder="Alamat Pengiriman Lengkap" disabled>
                    <input type="text" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg" placeholder="Nomor Telepon (Aktif)" disabled>
                    <select class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg" disabled><option>-- Pilih Kurir --</option></select>
                    <textarea class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg" rows="2" placeholder="Catatan Pesanan (Opsional)" disabled></textarea>
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mt-6">
                        <div class="flex justify-between text-lg font-bold text-gray-800 dark:text-white">
                            <span>Subtotal</span>
                            <span id="subtotal">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold text-gray-800 dark:text-white mb-2">
                            <span>Ongkir</span>
                            <span id="ongkir">Rp {{ number_format($couriers[0]['cost'], 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-xl font-extrabold text-green-600 dark:text-green-400 mt-4">
                            <span>Total</span>
                            <span id="total">Rp {{ number_format($subtotal + $couriers[0]['cost'], 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <button type="button" class="w-full mt-8 bg-gray-400 text-white py-4 rounded-xl font-extrabold text-lg shadow-lg cursor-not-allowed flex items-center justify-center gap-2" disabled>
                        <i class="fas fa-money-check-alt"></i> Bayar Sekarang
                    </button>
                </form>
                @endauth
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function applyCoupon() {
    const couponCode = document.getElementById('coupon_code').value;
    const subtotal = {{ $subtotal }};
    
    fetch('/api/coupons/apply', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            code: couponCode,
            subtotal: subtotal
        })
    })
    .then(response => response.json())
    .then(data => {
        const messageDiv = document.getElementById('coupon_message');
        const discountRow = document.getElementById('discount_row');
        const discountAmount = document.getElementById('discount_amount');
        const totalAmount = document.getElementById('total_amount');
        
        if (data.success) {
            messageDiv.className = 'mt-2 text-sm text-green-600';
            messageDiv.textContent = data.message;
            
            // Tampilkan diskon
            discountRow.classList.remove('hidden');
            discountAmount.textContent = `- Rp ${data.data.discount.toLocaleString('id-ID')}`;
            
            // Update total
            const shippingCost = parseInt(document.querySelector('select[name="kurir"] option:checked').dataset.cost);
            const newTotal = data.data.final_total + shippingCost;
            totalAmount.textContent = `Rp ${newTotal.toLocaleString('id-ID')}`;
        } else {
            messageDiv.className = 'mt-2 text-sm text-red-600';
            messageDiv.textContent = data.message;
            
            // Sembunyikan diskon
            discountRow.classList.add('hidden');
            
            // Reset total
            const shippingCost = parseInt(document.querySelector('select[name="kurir"] option:checked').dataset.cost);
            totalAmount.textContent = `Rp ${(subtotal + shippingCost).toLocaleString('id-ID')}`;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('coupon_message').className = 'mt-2 text-sm text-red-600';
        document.getElementById('coupon_message').textContent = 'Terjadi kesalahan saat menerapkan kupon';
    });
}

// Update total when courier changes
document.querySelector('select[name="kurir"]').addEventListener('change', function() {
    const shippingCost = parseInt(this.options[this.selectedIndex].dataset.cost);
    const subtotal = {{ $subtotal }};
    const discountAmount = parseFloat(document.getElementById('discount_amount').textContent.replace(/[^0-9.-]+/g, '')) || 0;
    const total = subtotal + shippingCost - discountAmount;
    document.getElementById('shipping_cost').textContent = `Rp ${shippingCost.toLocaleString('id-ID')}`;
    document.getElementById('total_amount').textContent = `Rp ${total.toLocaleString('id-ID')}`;
});
</script>
@endpush
@endsection 