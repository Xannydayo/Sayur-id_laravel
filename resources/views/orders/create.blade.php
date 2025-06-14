<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Order') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('orders.store') }}" class="space-y-6">
                        @csrf

                        @if ($product)
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div>
                                <x-input-label for="product_name" :value="__('Product')" />
                                <x-text-input id="product_name" type="text" class="mt-1 block w-full" value="{{ $product->name }}" disabled />
                            </div>
                            <div>
                                <x-input-label for="quantity" :value="__('Quantity')" />
                                <x-text-input id="quantity" name="quantity" type="number" class="mt-1 block w-full" min="1" value="1" required />
                                <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                            </div>
                        @else
                            <p class="text-red-500">No product selected for order.</p>
                        @endif

                        <!-- Shipping Address -->
                        <div>
                            <x-input-label for="shipping_address" :value="__('Shipping Address')" />
                            <x-text-input id="shipping_address" name="shipping_address" type="text" class="mt-1 block w-full" required />
                            <x-input-error :messages="$errors->get('shipping_address')" class="mt-2" />
                        </div>

                        <!-- Shipping Phone -->
                        <div>
                            <x-input-label for="shipping_phone" :value="__('Phone Number')" />
                            <x-text-input id="shipping_phone" name="shipping_phone" type="text" class="mt-1 block w-full" required />
                            <x-input-error :messages="$errors->get('shipping_phone')" class="mt-2" />
                        </div>

                        <!-- Courier -->
                        <div>
                            <x-input-label for="courier" :value="__('Select Courier')" />
                            <select id="courier" name="courier" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" onchange="updateCourierInfo()">
                                <option value="">-- Select a Courier --</option>
                                <option value="JNE" data-price="15000" data-estimate="2-3 hari">JNE</option>
                                <option value="TIKI" data-price="14000" data-estimate="2-4 hari">TIKI</option>
                                <option value="POS Indonesia" data-price="12000" data-estimate="3-5 hari">POS Indonesia</option>
                                <option value="SiCepat" data-price="16000" data-estimate="1-2 hari">SiCepat</option>
                                <option value="J&T Express" data-price="15500" data-estimate="2-3 hari">J&T Express</option>
                            </select>
                            <x-input-error :messages="$errors->get('courier')" class="mt-2" />
                            <div id="courier-info" class="mt-2 text-sm text-gray-700 dark:text-gray-300"></div>
                        </div>

                        <!-- Notes -->
                        <div>
                            <x-input-label for="notes" :value="__('Order Notes (Optional)')" />
                            <textarea id="notes" name="notes" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" rows="4"></textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Create Order') }}</x-primary-button>
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
        infoDiv.innerHTML = `Ongkir: Rp ${parseInt(price).toLocaleString('id-ID')}<br>Estimasi: ${estimate}`;
    } else {
        infoDiv.innerHTML = '';
    }
}
document.addEventListener('DOMContentLoaded', updateCourierInfo);
</script>
@endpush 