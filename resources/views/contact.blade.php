@extends('layout')

@section('content')

<!-- Single Page Header Start -->
<div class="bg-gradient-to-r from-green-500 to-green-700 py-16 text-white text-center shadow-lg">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-3">Kontak Kami</h1>
        <nav class="text-sm font-medium" aria-label="breadcrumb">
            <ol class="flex justify-center items-center space-x-2">
                <li><a href="{{ route('home') }}" class="hover:underline">Home</a></li>
                <li class="flex items-center">
                    <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20"><path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path></svg>
                    <span class="text-gray-200">Kontak Kami</span>
                </li>
            </ol>
        </nav>
    </div>
</div>
<!-- Single Page Header End -->


<!-- Contact Start -->
<div class="container mx-auto px-4 py-16">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
        <div class="text-center mx-auto mb-12 max-w-2xl">
            <h2 class="text-4xl font-extrabold text-gray-800 dark:text-gray-100 mb-4">Hubungi Kami</h2>
            <p class="text-gray-600 dark:text-gray-300 text-lg">Kami siap membantu Anda! Jangan ragu untuk menghubungi kami melalui informasi di bawah ini atau formulir kontak.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <div class="flex items-start p-6 bg-gray-50 dark:bg-gray-700 rounded-lg shadow-sm">
                <i class="fas fa-map-marker-alt fa-2x text-green-600 mr-4"></i>
                <div>
                    <h4 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-1">Alamat</h4>
                    <p class="text-gray-600 dark:text-gray-300">Jalan Ulujami, Kec. Ulujami, Jakarta</p>
                </div>
            </div>
            <div class="flex items-start p-6 bg-gray-50 dark:bg-gray-700 rounded-lg shadow-sm">
                <i class="fas fa-envelope fa-2x text-green-600 mr-4"></i>
                <div>
                    <h4 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-1">Email Kami</h4>
                    <p class="text-gray-600 dark:text-gray-300">info@sayurid.com</p>
                </div>
            </div>
            <div class="flex items-start p-6 bg-gray-50 dark:bg-gray-700 rounded-lg shadow-sm">
                <i class="fa fa-phone-alt fa-2x text-green-600 mr-4"></i>
                <div>
                    <h4 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-1">Telepon</h4>
                    <p class="text-gray-600 dark:text-gray-300">+62 882 2575 3457</p>
                </div>
            </div>
        </div>

        <div class="relative w-full h-96 rounded-lg overflow-hidden shadow-lg">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4276.0545290269365!2d106.76239749999999!3d-6.2379431!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f12221e5c851%3A0xfe59939728df4327!2sUniversitas%20Bina%20Sarana%20Informatika%20Ciledug%20(UBSI%20Ciledug)!5e1!3m2!1sen!2sid!4v1749387839484!5m2!1sen!2sid"
                class="absolute top-0 left-0 w-full h-full border-0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>

        <!-- Optional: Contact Form Section -->
        <div class="mt-12 pt-12 border-t border-gray-200 dark:border-gray-700">
            <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6 text-center">Kirim Pesan Kepada Kami</h3>
            <form class="space-y-6 max-w-lg mx-auto">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Lengkap</label>
                    <input type="text" id="name" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" placeholder="Nama Anda">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                    <input type="email" id="email" name="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" placeholder="email@contoh.com">
                </div>
                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Subjek</label>
                    <input type="text" id="subject" name="subject" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" placeholder="Subjek pesan Anda">
                </div>
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pesan</label>
                    <textarea id="message" name="message" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" placeholder="Tulis pesan Anda di sini..."></textarea>
                </div>
                <div>
                    <button type="submit" class="w-full inline-flex justify-center py-3 px-6 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Kirim Pesan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Contact End -->

@endsection