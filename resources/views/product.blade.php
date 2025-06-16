@extends('layout')

@section('content')

<!-- Single Page Header Start -->
<div class="bg-green-600 py-16 text-white text-center shadow-lg">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-3">Produk Kami</h1>
        <nav class="text-sm font-medium" aria-label="breadcrumb">
            <ol class="flex justify-center items-center space-x-2">
                <li><a href="{{ route('home') }}" class="hover:underline text-gray-100">Home</a></li>
                <li class="flex items-center">
                    <svg class="w-4 h-4 mx-2 text-gray-100" fill="currentColor" viewBox="0 0 20 20"><path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path></svg>
                    <span class="text-white">Produk</span>
                </li>
            </ol>
        </nav>
    </div>
</div>
<!-- Single Page Header End -->


<!-- Fruits Shop Start-->
<div class="container mx-auto px-4 py-16">
    <div class="lg:flex lg:space-x-8">
        <!-- Sidebar Start -->
        <div class="lg:w-1/4 mb-8 lg:mb-0">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h4 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">Kategori</h4>
                <ul class="space-y-2">
                    @foreach ($categories as $category)
                    <li class="border-b border-gray-200 dark:border-gray-700 last:border-b-0 py-2">
                        <a href="{{ route('product.category',$category->slug) }}" class="flex justify-between items-center text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400">
                            <span>{{ $category->judul }}</span>
                            <span class="px-2 py-1 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-full text-xs">({{ $category->products->count() }})</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
            
            @if ($promotion)
            <div class="mt-8 bg-green-600 dark:bg-green-800 rounded-lg shadow-md overflow-hidden relative">
                <img src="{{ Storage::url($promotion->gambar) }}" class="w-full h-48 object-cover" alt="Promotion Banner">
                <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center p-4">
                    <div class="text-white text-center">
                        <h3 class="text-2xl font-bold mb-2">Diskon {{ $promotion->discount_percentage ?? '' }}%</h3>
                        <p class="text-base">Semua Produk Pilihan</p>
                        <a href="{{ route('product') }}" class="mt-4 inline-block bg-white text-green-700 font-semibold py-2.5 px-6 rounded-full hover:bg-gray-100 transition duration-300">Lihat Promo</a>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <!-- Sidebar End -->

        <!-- Product List Start -->
        <div class="lg:w-3/4">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-4xl md:text-5xl font-extrabold text-gray-800 dark:text-gray-100">Produk Segar Kami</h2>
                <form action="{{ route('product') }}" method="GET" class="relative flex items-center space-x-2">
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    <label for="sort_by" class="text-sm font-medium text-gray-700 dark:text-gray-300">Urut Berdasarkan:</label>
                    <select id="sort_by" onchange="this.form.submit()" name="sort_by" class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm py-2 pl-3 pr-10">
                        <option value="terbaru" {{ $sortBy == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                        <option value="nama_asc" {{ $sortBy == 'nama_asc' ? 'selected' : '' }}>Nama (A-Z)</option>
                        <option value="nama_desc" {{ $sortBy == 'nama_desc' ? 'selected' : '' }}>Nama (Z-A)</option>
                        <option value="harga_asc" {{ $sortBy == 'harga_asc' ? 'selected' : '' }}>Harga (Termurah)</option>
                        <option value="harga_desc" {{ $sortBy == 'harga_desc' ? 'selected' : '' }}>Harga (Termahal)</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:text-gray-300" style="right: 0.5rem;">
                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </form>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($products as $product)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden transform transition-transform duration-300 hover:scale-105 group">
                        <div class="relative">
                            <img src="{{ Storage::url($product->gambar) }}" class="w-full h-56 object-cover rounded-t-lg" alt="{{ $product->nama }}">
                            <span class="absolute top-3 left-3 bg-green-500 text-white text-sm font-semibold px-3 py-1 rounded-full">{{ $product->category->judul }}</span>
                            @auth
                                <button onclick="toggleWishlist(this, {{ $product->id }})" class="absolute top-3 right-3 text-gray-400 hover:text-red-500 focus:outline-none transition-colors duration-300 {{ in_array($product->id, $wishlistedProductIds) ? 'text-red-500' : '' }}">
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </button>
                            @endauth
                        </div>
                        <div class="p-5 flex flex-col items-center text-center">
                            <h5 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-2 truncate group-hover:text-green-600 transition-colors duration-300">{{ $product->nama }}</h5>
                            <p class="text-green-700 dark:text-green-400 text-2xl font-bold mb-4">Rp {{ number_format($product->harga, 0, ',', '.') }} / kg</p>
                            @if($product->total_reviews > 0)
                                <div class="flex items-center mb-4">
                                    <div class="flex text-yellow-500 mr-2">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= round($product->average_rating))
                                                <i class="fas fa-star"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">({{ $product->total_reviews }})</span>
                                </div>
                            @endif
                            <a href="{{ route('product.show', $product->slug) }}" class="inline-flex items-center bg-green-600 text-white font-bold py-2 px-5 rounded-full shadow-md hover:bg-green-700 transition duration-300">
                                <i class="fa fa-eye mr-2"></i> Detail
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <!-- Product List End -->
    </div>
</div>
<!-- Fruits Shop End-->

@endsection