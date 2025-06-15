@extends('layout')

@section('content')

<!-- Single Page Header Start -->
<div class="bg-green-600 py-16 text-white text-center shadow-lg">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-3">Lacak Pesanan Anda</h1>
        <nav class="text-sm font-medium" aria-label="breadcrumb">
            <ol class="flex justify-center items-center space-x-2">
                <li><a href="{{ route('home') }}" class="hover:underline text-gray-100">Home</a></li>
                <li class="flex items-center">
                    <svg class="w-4 h-4 mx-2 text-gray-100" fill="currentColor" viewBox="0 0 20 20"><path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path></svg>
                    <span class="text-white">Pesanan Saya</span>
                </li>
            </ol>
        </nav>
    </div>
</div>
<!-- Single Page Header End -->

<div class="container mx-auto px-4 py-16">
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if ($orders->isEmpty())
        <div class="text-center py-10">
            <p class="text-gray-600 dark:text-gray-300 text-lg">Anda belum memiliki pesanan.</p>
            <a href="{{ route('product') }}" class="mt-4 inline-block bg-green-600 text-white font-bold py-2 px-4 rounded-full hover:bg-green-700 transition duration-300">Mulai Belanja</a>
        </div>
    @else
        <div class="mb-8">
            <h2 class="text-3xl font-extrabold text-gray-800 dark:text-gray-100 mb-6">Pesanan Pending</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($orders->where('status', 'pending') as $order)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
                        @if ($order->products->first())
                            <div class="flex items-center mb-4">
                                <img src="{{ asset('storage/' . $order->products->first()->gambar) }}" alt="{{ $order->products->first()->nama }}" class="w-16 h-16 object-cover rounded-md mr-4 shadow-sm">
                                <p class="text-lg font-semibold text-gray-800 dark:text-gray-100">{{ $order->products->first()->nama }}</p>
                            </div>
                        @endif
                        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-2">Order #{{ $order->order_number }}</h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-1">Total: Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                        <p class="text-gray-600 dark:text-gray-300 mb-1">Status: <span class="text-yellow-600 font-semibold">{{ ucfirst($order->status) }}</span></p>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">Tanggal: {{ $order->created_at->format('d M Y') }}</p>
                        <a href="{{ route('orders.show', $order->id) }}" class="inline-flex items-center bg-green-600 text-white font-bold py-2 px-4 rounded-full shadow-md hover:bg-green-700 transition duration-300">
                            Detail Pesanan <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                @endforeach
            </div>
            @if($orders->where('status', 'pending')->isEmpty())
                <p class="text-gray-600 dark:text-gray-300 text-center py-4">Tidak ada pesanan pending saat ini.</p>
            @endif
        </div>

        <div>
            <h2 class="text-3xl font-extrabold text-gray-800 dark:text-gray-100 mb-6">Pesanan Selesai</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($orders->where('status', 'completed') as $order)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border-l-4 border-green-500">
                        @if ($order->products->first())
                            <div class="flex items-center mb-4">
                                <img src="{{ asset('storage/' . $order->products->first()->gambar) }}" alt="{{ $order->products->first()->nama }}" class="w-16 h-16 object-cover rounded-md mr-4 shadow-sm">
                                <p class="text-lg font-semibold text-gray-800 dark:text-gray-100">{{ $order->products->first()->nama }}</p>
                            </div>
                        @endif
                        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-2">Order #{{ $order->order_number }}</h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-1">Total: Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                        <p class="text-gray-600 dark:text-gray-300 mb-1">Status: <span class="text-green-600 font-semibold">{{ ucfirst($order->status) }}</span></p>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">Tanggal: {{ $order->created_at->format('d M Y') }}</p>
                        <a href="{{ route('orders.show', $order->id) }}" class="inline-flex items-center bg-green-600 text-white font-bold py-2 px-4 rounded-full shadow-md hover:bg-green-700 transition duration-300">
                            Detail Pesanan <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                @endforeach
            </div>
            @if($orders->where('status', 'completed')->isEmpty())
                <p class="text-gray-600 dark:text-gray-300 text-center py-4">Tidak ada pesanan selesai saat ini.</p>
            @endif
        </div>
    @endif
</div>

@endsection 