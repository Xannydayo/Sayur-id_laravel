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
            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-800 dark:text-gray-100 mb-6">Produk Segar Kami</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($products as $product)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden transform transition-transform duration-300 hover:scale-105">
                        <div class="relative">
                            <img src="{{ Storage::url($product->gambar) }}" class="w-full h-56 object-cover rounded-t-lg" alt="{{ $product->nama }}">
                            <span class="absolute top-3 left-3 bg-green-500 text-white text-sm font-semibold px-3 py-1 rounded-full">{{ $product->category->judul }}</span>
                        </div>
                        <div class="p-5 flex flex-col items-center text-center">
                            <h5 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-2">{{ $product->nama }}</h5>
                            <p class="text-green-700 dark:text-green-400 text-2xl font-bold mb-4">Rp {{ number_format($product->harga, 0, ',', '.') }} / kg</p>
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