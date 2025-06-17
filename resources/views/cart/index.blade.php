@extends('layout')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-8">Keranjang Belanja</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Cart Items -->
        <div class="lg:col-span-2">
            @if(count($cartItems) > 0)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-4">
                    <div class="space-y-4">
                        @foreach($cartItems as $item)
                            <div class="flex items-center justify-between border-b border-gray-200 dark:border-gray-700 pb-4">
                                <div class="flex items-center space-x-4">
                                    <img src="{{ asset('storage/' . $item->product->gambar) }}" alt="{{ $item->product->nama }}" class="w-20 h-20 object-cover rounded-lg">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">{{ $item->product->nama }}</h3>
                                        <p class="text-gray-600 dark:text-gray-400">Rp {{ number_format($item->product->harga, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-lg">
                                        <button onclick="updateQuantity({{ $item->id }}, 'decrease')" class="px-3 py-1 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-l-lg">-</button>
                                        <span class="px-3 py-1 text-gray-800 dark:text-white">{{ $item->quantity }}</span>
                                        <button onclick="updateQuantity({{ $item->id }}, 'increase')" class="px-3 py-1 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-r-lg">+</button>
                                    </div>
                                    <button onclick="removeItem({{ $item->id }})" class="text-red-500 hover:text-red-700">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 text-center">
                    <i class="fas fa-shopping-cart text-4xl text-gray-400 mb-4"></i>
                    <p class="text-gray-600 dark:text-gray-400">Keranjang belanja Anda kosong</p>
                    <a href="{{ route('product') }}" class="inline-block mt-4 px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-300">
                        Belanja Sekarang
                    </a>
                </div>
            @endif
        </div>

        <!-- Order Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Ringkasan Pesanan</h2>
                <div class="space-y-4">
                    <div class="flex justify-between text-gray-600 dark:text-gray-400">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600 dark:text-gray-400">
                        <span>Pengiriman</span>
                        <span>Rp {{ number_format($shipping, 0, ',', '.') }}</span>
                    </div>
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                        <div class="flex justify-between text-lg font-semibold text-gray-800 dark:text-white">
                            <span>Total</span>
                            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    @if(count($cartItems) > 0)
                        <a href="{{ route('checkout') }}" class="block w-full text-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-300">
                            Lanjut ke Pembayaran
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function updateQuantity(itemId, action) {
        fetch(`/cart/update/${itemId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ action })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    function removeItem(itemId) {
        if (confirm('Apakah Anda yakin ingin menghapus item ini dari keranjang?')) {
            fetch(`/cart/remove/${itemId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    }
</script>
@endpush
@endsection 