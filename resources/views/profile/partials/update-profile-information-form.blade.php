<section>
    <header>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">
            {{ __('Informasi Profil Anda') }}
        </h2>

        <p class="mt-1 text-base text-gray-600 dark:text-gray-400 mb-6">
            {{ __("Perbarui informasi akun, alamat email, dan detail kontak Anda.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-8" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="flex items-center space-x-6 mb-8">
            <div class="shrink-0">
                @if ($user->profile_photo_path)
                    <img class="h-24 w-24 rounded-full object-cover shadow-lg border-2 border-gray-300 dark:border-gray-600" src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="{{ $user->name }}" />
                @else
                    <svg class="h-24 w-24 text-gray-300 dark:text-gray-700 rounded-full border-2 border-gray-300 dark:border-gray-600 p-1" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 20.993V24H0v-2.993C0 17.514 4.032 14 9 14h6c4.968 0 9 3.514 9 6.993zM12 13c-3.315 0-6-2.685-6-6s2.685-6 6-6 6 2.685 6 6-2.685 6-6 6z" />
                    </svg>
                @endif
            </div>
            <label for="profile_photo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                {{ __('Foto Profil') }}
                <input id="profile_photo" name="profile_photo" type="file" class="hidden" accept="image/*" />
                <span x-data="{}" x-on:click="document.getElementById('profile_photo').click()" class="inline-flex items-center px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white font-bold rounded-full shadow-md transition duration-300 ease-in-out transform hover:scale-105 cursor-pointer">
                    {{ __('Pilih Foto Baru') }}
                </span>
            </label>
            <x-input-error class="mt-2" :messages="$errors->get('profile_photo')" />
        </div>

        <div class="space-y-6">
            <div>
                <x-input-label for="name" :value="__('Nama Lengkap')" class="text-lg font-medium" />
                <x-text-input id="name" name="name" type="text" class="mt-2 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-green-500 focus:border-green-500 dark:bg-gray-900 dark:text-gray-100" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="email" :value="__('Alamat Email')" class="text-lg font-medium" />
                <x-text-input id="email" name="email" type="email" class="mt-2 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-green-500 focus:border-green-500 dark:bg-gray-900 dark:text-gray-100" :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-2 p-3 bg-yellow-50 dark:bg-yellow-800/20 border border-yellow-200 dark:border-yellow-700 rounded-lg text-yellow-800 dark:text-yellow-200">
                        <p class="text-sm">
                            {{ __('Alamat email Anda belum terverifikasi.') }}

                            <button form="send-verification" class="underline text-sm text-yellow-600 dark:text-yellow-400 hover:text-yellow-900 dark:hover:text-yellow-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 dark:focus:ring-offset-yellow-800">
                                {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                {{ __('Tautan verifikasi baru telah dikirim ke alamat email Anda.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>

            <div>
                <x-input-label for="phone" :value="__('Nomor Telepon')" class="text-lg font-medium" />
                <x-text-input id="phone" name="phone" type="text" class="mt-2 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-green-500 focus:border-green-500 dark:bg-gray-900 dark:text-gray-100" :value="old('phone', $user->phone)" autocomplete="tel" placeholder="Contoh: 081234567890" />
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>
        </div>

        <hr class="my-8 border-gray-200 dark:border-gray-700">

        <div class="space-y-6">
            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100">{{ __('Alamat Default') }}</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Isi alamat ini untuk digunakan sebagai alamat pengiriman default Anda saat memesan.') }}</p>

            <div>
                <x-input-label for="address" :value="__('Alamat Lengkap')" class="text-lg font-medium" />
                <x-text-input id="address" name="address" type="text" class="mt-2 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-green-500 focus:border-green-500 dark:bg-gray-900 dark:text-gray-100" :value="old('address', $user->address)" autocomplete="street-address" placeholder="Contoh: Jl. Merdeka No. 123" />
                <x-input-error class="mt-2" :messages="$errors->get('address')" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="city" :value="__('Kota')" class="text-lg font-medium" />
                    <x-text-input id="city" name="city" type="text" class="mt-2 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-green-500 focus:border-green-500 dark:bg-gray-900 dark:text-gray-100" :value="old('city', $user->city)" autocomplete="address-level2" placeholder="Contoh: Jakarta" />
                    <x-input-error class="mt-2" :messages="$errors->get('city')" />
                </div>

                <div>
                    <x-input-label for="province" :value="__('Provinsi')" class="text-lg font-medium" />
                    <x-text-input id="province" name="province" type="text" class="mt-2 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-green-500 focus:border-green-500 dark:bg-gray-900 dark:text-gray-100" :value="old('province', $user->province)" autocomplete="address-level1" placeholder="Contoh: Banten" />
                    <x-input-error class="mt-2" :messages="$errors->get('province')" />
                </div>
            </div>

            <div>
                <x-input-label for="postal_code" :value="__('Kode Pos')" class="text-lg font-medium" />
                <x-text-input id="postal_code" name="postal_code" type="text" class="mt-2 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-green-500 focus:border-green-500 dark:bg-gray-900 dark:text-gray-100" :value="old('postal_code', $user->postal_code)" autocomplete="postal-code" placeholder="Contoh: 12345" />
                <x-input-error class="mt-2" :messages="$errors->get('postal_code')" />
            </div>

            <div>
                <label for="is_default_address" class="inline-flex items-center">
                    <input id="is_default_address" name="is_default_address" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-green-600 shadow-sm focus:ring-green-500 dark:focus:ring-green-600 dark:focus:ring-offset-gray-800" value="1" @checked(old('is_default_address', $user->is_default_address)) />
                    <span class="ml-2 text-base text-gray-600 dark:text-gray-400">{{ __('Gunakan sebagai alamat pengiriman utama') }}</span>
                </label>
                <x-input-error class="mt-2" :messages="$errors->get('is_default_address')" />
            </div>
        </div>

        <div class="flex items-center justify-end mt-8">
            <x-primary-button class="ml-4 px-8 py-3 bg-green-600 hover:bg-green-700 focus:bg-green-700 active:bg-green-800 text-white font-bold rounded-full shadow-lg transition duration-300 ease-in-out transform hover:scale-105">
                {{ __('Simpan Perubahan') }} <i class="fas fa-save ml-2"></i>
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400 ml-4"
                >{{ __('Disimpan.') }}</p>
            @endif
        </div>
    </form>
</section>
