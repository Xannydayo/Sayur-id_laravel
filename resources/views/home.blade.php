@extends('layout')

@section('content')
<!-- Hero Section Start -->
<div class="relative w-full h-screen bg-cover bg-center flex items-center justify-center text-white p-4" style="background-image: url('{{ asset('img/hero-background.jpg') }}');">
    <div class="absolute inset-0 bg-black opacity-60"></div> <!-- Overlay for better text readability -->
    <div class="relative z-10 text-center max-w-4xl mx-auto">
        <h4 class="text-xl md:text-2xl font-semibold text-green-400 mb-4 tracking-wide uppercase">Sayur.id - Kualitas Terbaik dari Petani Lokal</h4>
        <h1 class="text-5xl md:text-7xl font-extrabold leading-tight mb-6 animate-fade-in-up">Sayuran & Buah Segar Organik Langsung ke Pintu Anda</h1>
        <p class="text-lg md:text-xl mb-10 opacity-90 animate-fade-in-up delay-200">Dapatkan produk-produk pilihan yang dipanen dengan cinta, untuk hidup yang lebih sehat dan bahagia.</p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ route('product') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-full shadow-lg transform hover:scale-105 transition duration-300 ease-in-out text-lg">
                Lihat Produk <i class="fas fa-arrow-right ml-2"></i>
            </a>
            <a href="{{ route('contact') }}" class="bg-transparent border-2 border-white hover:border-green-400 text-white font-bold py-3 px-8 rounded-full shadow-lg transform hover:scale-105 transition duration-300 ease-in-out text-lg">
                Hubungi Kami <i class="fas fa-phone-alt ml-2"></i>
            </a>
        </div>
    </div>
</div>
<!-- Hero Section End -->

<!-- Categories Section Start - Updated Design -->
<div class="container mx-auto px-4 py-16">
    <div class="text-center mx-auto mb-12 max-w-2xl">
        <h2 class="text-4xl font-extrabold text-gray-800 dark:text-gray-100 mb-4">Jelajahi Kategori Pilihan</h2>
        <p class="text-gray-600 dark:text-gray-300 text-lg">Temukan beragam produk segar berdasarkan kategori favorit Anda.</p>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
        @foreach ($categories as $category)
        <a href="{{ route('product.category',$category->slug) }}" class="block bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-2xl group">
            <div class="relative overflow-hidden">
                <img src="{{ asset('storage/' . $category->gambar) }}" class="w-full h-40 object-cover object-center group-hover:scale-110 transition-transform duration-500" alt="{{ $category->judul }}">
                <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-50 group-hover:opacity-70 transition-opacity duration-300"></div>
                <h5 class="absolute bottom-4 left-4 text-xl font-bold text-white group-hover:text-green-300 transition-colors duration-300">{{ $category->judul }}</h5>
            </div>
        </a>
        @endforeach
    </div>
</div>
<!-- Categories Section End -->

<!-- Featurs Section Start -->
<div class="container mx-auto px-4 py-16">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 text-center transform transition-transform duration-300 hover:scale-105">
            <div class="bg-green-100 dark:bg-green-700 text-green-600 dark:text-green-200 p-4 rounded-full inline-flex mb-4">
                <i class="fas fa-truck fa-2x"></i>
            </div>
            <h5 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-2">Gratis Ongkir</h5>
            <p class="text-gray-600 dark:text-gray-300">Untuk pesanan di atas Rp 300.000</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 text-center transform transition-transform duration-300 hover:scale-105">
            <div class="bg-blue-100 dark:bg-blue-700 text-blue-600 dark:text-blue-200 p-4 rounded-full inline-flex mb-4">
                <i class="fas fa-shield-alt fa-2x"></i>
            </div>
            <h5 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-2">Pembayaran Aman</h5>
            <p class="text-gray-600 dark:text-gray-300">Pembayaran 100% aman dan terenkripsi</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 text-center transform transition-transform duration-300 hover:scale-105">
            <div class="bg-purple-100 dark:bg-purple-700 text-purple-600 dark:text-purple-200 p-4 rounded-full inline-flex mb-4">
                <i class="fas fa-exchange-alt fa-2x"></i>
            </div>
            <h5 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-2">Garansi 30 Hari</h5>
            <p class="text-gray-600 dark:text-gray-300">Garansi uang kembali 30 hari</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 text-center transform transition-transform duration-300 hover:scale-105">
            <div class="bg-red-100 dark:bg-red-700 text-red-600 dark:text-red-200 p-4 rounded-full inline-flex mb-4">
                <i class="fas fa-headset fa-2x"></i>
            </div>
            <h5 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-2">Dukungan 24/7</h5>
            <p class="text-gray-600 dark:text-gray-300">Dukungan pelanggan responsif setiap saat</p>
        </div>
    </div>
</div>
<!-- Featurs Section End -->

<!-- Banner Section Start-->
<div class="container mx-auto px-4">
    <div class="bg-green-600 dark:bg-green-800 py-16 my-10 rounded-lg shadow-xl px-12">
        <div class="flex flex-col lg:flex-row items-center justify-between gap-16">
            <div class="w-full lg:w-1/2 text-center lg:text-left">
                <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-4">Promo Terbaik Bulan Ini</h1>
                <p class="text-base text-white mb-6 opacity-90">Dapatkan berbagai macam produk berkualitas dengan harga terjangkau.</p>
                <a href="{{ route('product') }}" class="inline-block bg-white text-green-700 font-bold py-2.5 px-6 rounded-full shadow-lg hover:bg-gray-100 transition duration-300">
                    Beli Sekarang <i class="fas fa-shopping-cart ml-2"></i>
                </a>
            </div>
            <div class="w-full lg:w-1/2 flex justify-center lg:justify-end relative">
                @if ($promotion)
                    <img src="{{ Storage::url($promotion->gambar) }}" class="w-full md:w-3/4 lg:w-full max-w-sm rounded-lg shadow-2xl transform hover:scale-105 transition-transform duration-500" alt="Promotion Image">
                @else
                    <div class="bg-gray-200 dark:bg-gray-700 w-full md:w-3/4 lg:w-full max-w-sm h-64 rounded-lg flex items-center justify-center text-gray-500 dark:text-gray-400">
                        No promotion image available.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- Banner Section End -->


<!-- Bestsaler Product Start -->
<div class="container mx-auto px-4 py-16">
    <div class="text-center mx-auto mb-12" style="max-width: 700px;">
        <h1 class="text-4xl md:text-5xl font-extrabold text-gray-800 dark:text-gray-100 mb-4">Produk Kami</h1>
        <p class="text-gray-600 dark:text-gray-300 text-lg">Nikmati kesegaran dan kualitas terbaik dari pilihan produk organik kami.</p>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        @foreach($products as $product)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden transform transition-transform duration-300 hover:scale-105">
            <img src="{{ asset('storage/' . $product->gambar) }}" class="w-full h-48 object-cover" alt="{{ $product->nama }}">
            <div class="p-6">
                <a href="{{ route('product.show', $product->slug) }}" class="block text-xl font-semibold text-gray-800 dark:text-gray-100 hover:text-green-600 dark:hover:text-green-400 mb-2">{{ $product->nama }}</a>
                <h4 class="text-2xl font-bold text-green-700 dark:text-green-400 mb-3">Rp {{ number_format($product->harga, 0, ',', '.') }} / kg</h4>
                <a href="{{ route('product.show', $product->slug) }}"
                    class="inline-flex items-center bg-green-600 text-white font-bold py-2 px-4 rounded-full shadow-md hover:bg-green-700 transition duration-300">
                    <i class="fa fa-eye mr-2"></i> Detail
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
<!-- Bestsaler Product End -->

<!-- Testimonial Start -->
<div class="bg-gray-50 dark:bg-gray-900 py-16">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h4 class="text-green-600 text-lg font-semibold mb-2">Testimonial</h4>
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-800 dark:text-gray-100">Apa Yang Klien Kami Katakan</h1>
        </div>
        <!-- This section usually requires a JS carousel library. For simplicity, I'll show static items. If you have an Owl Carousel equivalent in JS (e.g., swiper.js or custom), it needs to be integrated. -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 relative">
                <i class="fas fa-quote-right fa-2x text-gray-200 dark:text-gray-700 absolute top-6 right-6"></i>
                <p class="text-gray-700 dark:text-gray-300 mb-4">Produknya segar serta pengantaran sangat cepat sekali</p>
                <div class="flex items-center">
                    <img src="{{ asset('img/123.jpg') }}" class="w-16 h-16 rounded-full object-cover mr-4 shadow-md" alt="Client 1">
                    <div>
                        <h5 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Sumarti</h5>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Ibu Rumah Tangga</p>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 relative">
                <i class="fas fa-quote-right fa-2x text-gray-200 dark:text-gray-700 absolute top-6 right-6"></i>
                <p class="text-gray-700 dark:text-gray-300 mb-4">Produknya segar serta pengantaran sangat cepat sekali</p>
                <div class="flex items-center">
                    <img src="{{ asset('img/234.jpg') }}" class="w-16 h-16 rounded-full object-cover mr-4 shadow-md" alt="Client 2">
                    <div>
                        <h5 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Budi Santoso</h5>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Pengusaha</p>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 relative">
                <i class="fas fa-quote-right fa-2x text-gray-200 dark:text-gray-700 absolute top-6 right-6"></i>
                <p class="text-gray-700 dark:text-gray-300 mb-4">Produknya segar serta pengantaran sangat cepat sekali</p>
                <div class="flex items-center">
                    <img src="{{ asset('img/345.jpg') }}" class="w-16 h-16 rounded-full object-cover mr-4 shadow-md" alt="Client 3">
                    <div>
                        <h5 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Siti Aminah</h5>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Chef Rumahan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Testimonial End -->




@endsection