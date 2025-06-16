<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Wishlist Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($wishlists->isEmpty())
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Wishlist Kosong</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Anda belum menambahkan produk ke wishlist.</p>
                            <div class="mt-6">
                                <a href="{{ route('product') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Lihat Produk
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @foreach($wishlists as $wishlist)
                                <div class="bg-white dark:bg-gray-700 rounded-lg shadow-md overflow-hidden">
                                    <img src="{{ asset('storage/' . $wishlist->product->gambar) }}" alt="{{ $wishlist->product->nama }}" class="w-full h-48 object-cover">
                                    <div class="p-4">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $wishlist->product->nama }}</h3>
                                        <p class="text-gray-600 dark:text-gray-300 mt-2">Rp {{ number_format($wishlist->product->harga, 0, ',', '.') }}</p>
                                        <div class="mt-4 flex justify-between items-center">
                                            <button onclick="toggleWishlist({{ $wishlist->product->id }})" class="text-red-500 hover:text-red-600 focus:outline-none">
                                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                                </svg>
                                            </button>
                                            <a href="{{ route('product.show', $wishlist->product->id) }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                Lihat Detail
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function toggleWishlist(productId) {
            fetch(`/wishlist/toggle`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ product_id: productId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'removed') {
                    window.location.reload();
                }
            });
        }
    </script>
    @endpush
</x-app-layout> 