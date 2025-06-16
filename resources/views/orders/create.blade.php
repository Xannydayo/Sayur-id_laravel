<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Order') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6 text-center">Formulir Pemesanan</h3>
                    <form method="POST" action="{{ route('orders.store') }}" class="space-y-8">
                        @csrf

                        @if ($product)
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="p-6 bg-gray-50 dark:bg-gray-700 rounded-xl flex flex-col md:flex-row items-center shadow-md border border-gray-200 dark:border-gray-600">
                                <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama }}" class="w-32 h-32 object-cover rounded-lg mr-0 md:mr-6 mb-4 md:mb-0 shadow-sm border border-gray-300">
                                <div class="text-center md:text-left flex-grow">
                                    <h3 class="text-2xl font-extrabold text-gray-900 dark:text-gray-50 mb-2">Produk: {{ $product->nama }}</h3>
                                    <p class="text-xl font-semibold text-green-700 dark:text-green-400">Harga: Rp {{ number_format($product->harga, 0, ',', '.') }} / kg</p>
                                </div>
                            </div>
                            <div>
                                <x-input-label for="quantity" :value="__('Jumlah (kg)')" class="text-lg font-medium" />
                                <x-text-input id="quantity" name="quantity" type="number" class="mt-2 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-green-500 focus:border-green-500 dark:bg-gray-900 dark:text-gray-100" min="1" value="1" required />
                                <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                            </div>
                        @else
                            <p class="text-red-500 text-center text-lg">Tidak ada produk yang dipilih untuk pesanan.</p>
                        @endif

                        <!-- Shipping Address -->
                        <div>
                            <x-input-label for="shipping_address" :value="__('Alamat Pengiriman Lengkap')" class="text-lg font-medium" />
                            <x-text-input id="shipping_address" name="shipping_address" type="text" class="mt-2 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-green-500 focus:border-green-500 dark:bg-gray-900 dark:text-gray-100" required placeholder="Contoh: Jl. Merdeka No. 123, Kota Bandung, Jawa Barat" value="{{ old('shipping_address', Auth::user()->is_default_address ? Auth::user()->address . ', ' . Auth::user()->city . ', ' . Auth::user()->province . ' ' . Auth::user()->postal_code : '') }}" />
                            <x-input-error :messages="$errors->get('shipping_address')" class="mt-2" />
                        </div>

                        <!-- Shipping Phone -->
                        <div>
                            <x-input-label for="shipping_phone" :value="__('Nomor Telepon (Aktif)')" class="text-lg font-medium" />
                            <x-text-input id="shipping_phone" name="shipping_phone" type="text" class="mt-2 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-green-500 focus:border-green-500 dark:bg-gray-900 dark:text-gray-100" required placeholder="Contoh: 081234567890" value="{{ old('shipping_phone', Auth::user()->is_default_address ? Auth::user()->phone : '') }}" />
                            <x-input-error :messages="$errors->get('shipping_phone')" class="mt-2" />
                        </div>

                        <!-- Courier -->
                        <div>
                            <x-input-label for="courier" :value="__('Pilih Kurir Pengiriman')" class="text-lg font-medium" />
                            <select id="courier" name="courier" class="mt-2 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 focus:ring-green-500 focus:border-green-500 rounded-lg shadow-sm" onchange="updateCourierInfo()">
                                <option value="">-- Pilih Kurir --</option>
                                <option value="JNE" data-price="15000" data-estimate="2-3 hari">JNE</option>
                                <option value="TIKI" data-price="14000" data-estimate="2-4 hari">TIKI</option>
                                <option value="POS Indonesia" data-price="12000" data-estimate="3-5 hari">POS Indonesia</option>
                                <option value="SiCepat" data-price="16000" data-estimate="1-2 hari">SiCepat</option>
                                <option value="J&T Express" data-price="15500" data-estimate="2-3 hari">J&T Express</option>
                            </select>
                            <x-input-error :messages="$errors->get('courier')" class="mt-2" />
                            <div id="courier-info" class="mt-3 text-base text-gray-700 dark:text-gray-300 p-3 bg-gray-100 dark:bg-gray-700 rounded-md">Pilih kurir untuk melihat informasi ongkir dan estimasi pengiriman.</div>
                        </div>

                        <!-- Notes -->
                        <div>
                            <x-input-label for="notes" :value="__('Catatan Pesanan (Opsional)')" class="text-lg font-medium" />
                            <textarea id="notes" name="notes" class="mt-2 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 focus:ring-green-500 focus:border-green-500 rounded-lg shadow-sm" rows="4" placeholder="Contoh: Tolong kirimkan di pagi hari, buahnya yang matang ya."></textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end">
                            <x-primary-button class="ml-4 px-8 py-3 bg-green-600 hover:bg-green-700 focus:bg-green-700 active:bg-green-800 text-white font-bold rounded-full shadow-lg transition duration-300 ease-in-out transform hover:scale-105">
                                {{ __('Buat Pesanan') }} <i class="fas fa-arrow-right ml-2"></i>
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@push('scripts')
<script>
function updateCourierInfo() {
    const select = document.getElementById('courier');
    const infoDiv = document.getElementById('courier-info');
    const selected = select.options[select.selectedIndex];
    const price = selected.getAttribute('data-price');
    const estimate = selected.getAttribute('data-estimate');
    if (price && estimate) {
        infoDiv.innerHTML = `Ongkir: Rp ${parseInt(price).toLocaleString('id-ID')}<br>Estimasi Pengiriman: ${estimate}`;
    } else {
        infoDiv.innerHTML = 'Pilih kurir untuk melihat informasi ongkir dan estimasi pengiriman.';
    }
}
document.addEventListener('DOMContentLoaded', updateCourierInfo);
</script>
@endpush 