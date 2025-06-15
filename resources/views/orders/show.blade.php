@extends('layout')

@section('content')

<!-- Single Page Header Start -->
<div class="bg-green-600 py-16 text-white text-center shadow-lg">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-3">Detail Pesanan #{{ $order->order_number }}</h1>
        <nav class="text-sm font-medium" aria-label="breadcrumb">
            <ol class="flex justify-center items-center space-x-2">
                <li><a href="{{ route('home') }}" class="hover:underline text-gray-100">Home</a></li>
                <li class="flex items-center">
                    <svg class="w-4 h-4 mx-2 text-gray-100" fill="currentColor" viewBox="0 0 20 20"><path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path></svg>
                    <a href="{{ route('orders.index') }}" class="hover:underline text-gray-100">Pesanan Saya</a>
                </li>
                <li class="flex items-center">
                    <svg class="w-4 h-4 mx-2 text-gray-100" fill="currentColor" viewBox="0 0 20 20"><path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path></svg>
                    <span class="text-white">#{{ $order->order_number }}</span>
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
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 mb-8">
        <h2 class="text-3xl font-extrabold text-gray-800 dark:text-gray-100 mb-6">Informasi Pesanan</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700 dark:text-gray-300 mb-6">
            <div>
                <p><span class="font-semibold">Nomor Pesanan:</span> #{{ $order->order_number }}</p>
                <p><span class="font-semibold">Tanggal Pesanan:</span> {{ $order->created_at->format('d M Y H:i') }}</p>
                <p><span class="font-semibold">Status:</span> 
                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                        @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                        @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                        @elseif($order->status === 'completed') bg-green-100 text-green-800
                        @else bg-red-100 text-red-800
                        @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                </p>
                <p><span class="font-semibold">Total Jumlah:</span> Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
            </div>
            <div>
                <p><span class="font-semibold">Alamat Pengiriman:</span> {{ $order->shipping_address }}</p>
                <p><span class="font-semibold">Telepon Pengiriman:</span> {{ $order->shipping_phone }}</p>
                @if ($order->notes)
                    <p><span class="font-semibold">Catatan:</span> {{ $order->notes }}</p>
                @endif
                @if ($order->courier)
                    <p><span class="font-semibold">Kurir:</span> {{ ucfirst($order->courier) }}</p>
                @endif
            </div>
        </div>

        <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-4">Produk dalam Pesanan</h3>
        <div class="overflow-x-auto mb-6">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Produk</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jumlah</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Harga Satuan</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Subtotal</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ulasan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                    @foreach($order->products as $product)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ $product->nama }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">{{ $product->pivot->quantity }} kg</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">Rp {{ number_format($product->pivot->price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">Rp {{ number_format($product->pivot->quantity * $product->pivot->price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                            @php
                                $userReview = $product->reviews->where('user_id', auth()->id())->where('order_id', $order->id)->first();
                            @endphp
                            @if($order->status === 'completed')
                                @if($userReview)
                                    <div class="mb-2">
                                        <div class="flex items-center mb-1">
                                            <span class="font-semibold mr-2">Rating:</span>
                                            <span class="text-yellow-500">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $userReview->rating)
                                                        <i class="fas fa-star"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor
                                            </span>
                                        </div>
                                        @if($userReview->comment)
                                            <div class="text-gray-700 dark:text-gray-300 mb-1">{{ $userReview->comment }}</div>
                                        @endif
                                        @if($userReview->image)
                                            <img src="{{ asset('storage/' . $userReview->image) }}" alt="Review Image" class="w-20 h-20 object-cover rounded-lg border border-gray-300 dark:border-gray-600 mb-1">
                                        @endif
                                        <span class="text-xs text-gray-500">{{ $userReview->created_at->format('d M Y') }}</span>
                                    </div>
                                @else
                                    <form action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data" class="space-y-2 review-form">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                                        <div class="flex items-center space-x-1 review-rating-container">
                                            @for ($i = 5; $i >= 1; $i--)
                                                <input type="radio" id="rating_{{ $product->id }}_{{ $i }}" name="rating" value="{{ $i }}" class="hidden" />
                                                <label for="rating_{{ $product->id }}_{{ $i }}" class="cursor-pointer text-gray-400 dark:text-gray-500 hover:text-yellow-500 transition-colors duration-200 text-xl">
                                                    <i class="fas fa-star"></i>
                                                </label>
                                            @endfor
                                        </div>
                                        <textarea name="comment" rows="2" placeholder="Tulis ulasan..." class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-green-500 dark:focus:border-green-600 focus:ring-green-500 dark:focus:ring-green-600 rounded-md shadow-sm text-xs"></textarea>
                                        <input type="file" name="image" accept="image/*" class="block w-full text-xs text-gray-700 dark:text-gray-300 border-gray-300 dark:border-gray-700 rounded-md shadow-sm">
                                        <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded text-xs font-bold hover:bg-green-700">Kirim Ulasan</button>
                                    </form>
                                @endif
                            @else
                                <span class="italic text-gray-400">Ulasan hanya bisa diberikan jika pesanan selesai.</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex justify-between items-center">
            <a href="{{ route('orders.index') }}" class="inline-flex items-center bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded-full shadow-md hover:bg-gray-300 transition duration-300">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Pesanan
            </a>
            @if ($order->status === 'completed' && $order->payments->count() > 0)
                <a href="{{ route('payments.receipt.pdf', $order->payments->last()->id) }}" class="inline-flex items-center bg-blue-600 text-white font-bold py-2 px-4 rounded-full shadow-md hover:bg-blue-700 transition duration-300" target="_blank">
                    Cetak PDF <i class="fas fa-file-pdf ml-2"></i>
                </a>
            @elseif ($order->status === 'pending')
                <form action="{{ route('orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center bg-red-600 text-white font-bold py-2 px-4 rounded-full shadow-md hover:bg-red-700 transition duration-300">
                        <i class="fas fa-times-circle mr-2"></i> Batalkan Pesanan
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.review-form').forEach(form => {
        const ratingContainer = form.querySelector('.review-rating-container');
        const ratingInputs = ratingContainer.querySelectorAll('input[name="rating"]');
        const ratingLabels = ratingContainer.querySelectorAll('label[for^="rating_"]');

        // Function to update star colors for this specific form
        function updateStars(rating) {
            ratingLabels.forEach((label, index) => {
                const star = label.querySelector('i');
                // Stars are ordered from 5 to 1 in HTML, so index 0 is 5, index 1 is 4, etc.
                // We need to invert the index for comparison with the rating value.
                if ((5 - index) <= rating) {
                    star.classList.remove('far');
                    star.classList.add('fas');
                    label.classList.remove('text-gray-400', 'dark:text-gray-500');
                    label.classList.add('text-yellow-500');
                } else {
                    star.classList.remove('fas');
                    star.classList.add('far');
                    label.classList.remove('text-yellow-500');
                    label.classList.add('text-gray-400', 'dark:text-gray-500');
                }
            });
        }

        // Handle click on stars
        ratingLabels.forEach((label, index) => {
            label.addEventListener('click', () => {
                // The rating value is 5 - index, because stars are rendered from 5 to 1
                const ratingValue = 5 - index;
                const input = form.querySelector(`input[id="rating_${form.querySelector('input[name="product_id"]').value}_${ratingValue}"]`);
                if (input) {
                    input.checked = true;
                    updateStars(ratingValue);
                }
            });

            // Handle hover
            label.addEventListener('mouseenter', () => {
                const hoverRating = 5 - index;
                updateStars(hoverRating);
            });
        });

        // Handle mouse leave on the rating container
        ratingContainer.addEventListener('mouseleave', () => {
            const checkedInput = form.querySelector('input[name="rating"]:checked');
            if (checkedInput) {
                updateStars(parseInt(checkedInput.value));
            } else {
                updateStars(0);
            }
        });

        // Initialize stars based on any pre-selected rating
        const checkedInput = form.querySelector('input[name="rating"]:checked');
        if (checkedInput) {
            updateStars(parseInt(checkedInput.value));
        }
    });
});
</script>
@endpush 