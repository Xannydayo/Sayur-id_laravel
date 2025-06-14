@extends('layout')

@section('content')

<!-- Single Page Header Start -->
<div class="bg-gradient-to-r from-green-500 to-green-700 py-16 text-white text-center shadow-lg">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-3">Detail Produk</h1>
        <nav class="text-sm font-medium" aria-label="breadcrumb">
            <ol class="flex justify-center items-center space-x-2">
                <li><a href="{{ route('home') }}" class="hover:underline">Home</a></li>
                <li class="flex items-center">
                    <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20"><path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path></svg>
                    <a href="{{ route('product') }}" class="hover:underline">Produk</a>
                </li>
                <li class="flex items-center">
                    <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20"><path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path></svg>
                    <span class="text-gray-200">{{ $product->nama }}</span>
                </li>
            </ol>
        </nav>
    </div>
</div>
<!-- Single Page Header End -->


<!-- Single Product Start -->
<div class="container mx-auto px-4 py-16">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 mb-12">
        <div class="flex flex-col lg:flex-row gap-8">
            <div class="lg:w-1/2 flex justify-center items-center">
                <img src="{{ asset('storage/' . $product->gambar) }}" class="w-full max-w-md h-auto object-cover rounded-lg shadow-xl" alt="{{ $product->nama }}">
            </div>
            <div class="lg:w-1/2">
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-gray-100 mb-4">{{ $product->nama }}</h2>
                <p class="text-lg text-gray-600 dark:text-gray-300 mb-3">Kategori: <span class="font-semibold">{{ $product->category ? $product->category->judul : 'Tidak ada kategori' }}</span></p>
                <p class="text-4xl font-bold text-green-700 dark:text-green-400 mb-6">Rp {{ number_format($product->harga, 0, ',', '.') }} / Kg</p>
                <div class="text-gray-700 dark:text-gray-300 mb-8 leading-relaxed">
                    {!! $product->deskripsi_singkat !!}
                </div>
                @auth
                    <a href="{{ route('orders.create', ['product_id' => $product->id]) }}" class="inline-flex items-center bg-green-600 text-white font-bold py-3 px-8 rounded-full shadow-lg hover:bg-green-700 transition duration-300 text-lg">
                        <i class="fa fa-shopping-bag mr-3"></i> Beli Sekarang
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center bg-blue-600 text-white font-bold py-3 px-8 rounded-full shadow-lg hover:bg-blue-700 transition duration-300 text-lg">
                        <i class="fa fa-user mr-3"></i> Login untuk Membeli
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Product Description Start -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 mb-12">
        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">Deskripsi Produk</h3>
        <div class="text-gray-700 dark:text-gray-300 leading-relaxed">
            {!! $product->deskripsi_panjang !!}
        </div>
    </div>
    <!-- Product Description End -->

    <!-- Related Products Start -->
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-gray-100 mb-8 text-center">Produk Lainnya</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @foreach ($similar_products->take(4) as $similar_product)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden transform transition-transform duration-300 hover:scale-105">
                    <div class="relative">
                        <img src="{{ asset('storage/' . $similar_product->gambar) }}" class="w-full h-48 object-cover rounded-t-lg" alt="{{ $similar_product->nama }}">
                        <span class="absolute top-3 left-3 bg-green-500 text-white text-sm font-semibold px-3 py-1 rounded-full">{{ $similar_product->category->judul }}</span>
                    </div>
                    <div class="p-5 flex flex-col items-center text-center">
                        <h5 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-2">{{ $similar_product->nama }}</h5>
                        <p class="text-green-700 dark:text-green-400 text-2xl font-bold mb-4">Rp {{ number_format($similar_product->harga, 0, ',', '.') }} / kg</p>
                        <a href="{{ route('product.show', $similar_product->slug) }}" class="inline-flex items-center bg-green-600 text-white font-bold py-2 px-5 rounded-full shadow-md hover:bg-green-700 transition duration-300">
                            <i class="fa fa-eye mr-2"></i> Detail
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Related Products End -->

@endsection