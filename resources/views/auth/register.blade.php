<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
            <x-text-input id="name" 
                class="block mt-1 w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:border-green-500 dark:focus:border-green-400 focus:ring focus:ring-green-200 dark:focus:ring-green-800 focus:ring-opacity-50" 
                type="text" 
                name="name" 
                :value="old('name')" 
                required 
                autofocus 
                autocomplete="name"
                placeholder="Enter your name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
            <x-text-input id="email" 
                class="block mt-1 w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:border-green-500 dark:focus:border-green-400 focus:ring focus:ring-green-200 dark:focus:ring-green-800 focus:ring-opacity-50" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                autocomplete="username"
                placeholder="Enter your email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
            <div class="relative">
                <x-text-input id="password" 
                    class="block mt-1 w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:border-green-500 dark:focus:border-green-400 focus:ring focus:ring-green-200 dark:focus:ring-green-800 focus:ring-opacity-50 pr-10" 
                    type="password"
                    name="password"
                    required 
                    autocomplete="new-password"
                    placeholder="Create a password" />
                <button type="button" 
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 focus:outline-none"
                    onclick="togglePasswordVisibility('password')">
                    <svg class="h-5 w-5" id="password-toggle-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
            <div class="relative">
                <x-text-input id="password_confirmation" 
                    class="block mt-1 w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:border-green-500 dark:focus:border-green-400 focus:ring focus:ring-green-200 dark:focus:ring-green-800 focus:ring-opacity-50 pr-10" 
                    type="password"
                    name="password_confirmation" 
                    required 
                    autocomplete="new-password"
                    placeholder="Confirm your password" />
                <button type="button" 
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 focus:outline-none"
                    onclick="togglePasswordVisibility('password_confirmation')">
                    <svg class="h-5 w-5" id="password-confirmation-toggle-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
            <div id="password-match-error" class="mt-2 text-sm text-red-600 dark:text-red-400 hidden">
                Passwords do not match
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div>
            <x-primary-button id="register-button" class="w-full justify-center py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition duration-200">
                {{ __('Register') }}
            </x-primary-button>
        </div>

        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400">Or continue with</span>
            </div>
        </div>

        <div class="flex justify-center">
            <a href="{{ route('google.login') }}" 
               class="inline-flex items-center justify-center w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-200">
                <img src="https://upload.wikimedia.org/wikipedia/commons/4/4a/Logo_2013_Google.png" alt="Google" class="w-5 h-5 mr-2">
                <span class="text-sm font-medium">Sign up with Google</span>
            </a>
        </div>

        <div class="text-center mt-6">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                {{ __('Already have an account?') }}
                <a href="{{ route('login') }}" class="font-medium text-green-600 dark:text-green-400 hover:text-green-500 dark:hover:text-green-300">
                    {{ __('Login here') }}
                </a>
            </p>
        </div>
    </form>

    <script>
        function togglePasswordVisibility(inputId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(inputId === 'password' ? 'password-toggle-icon' : 'password-confirmation-toggle-icon');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                `;
            } else {
                input.type = 'password';
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                `;
            }
        }

        // Real-time password matching validation
        const password = document.getElementById('password');
        const passwordConfirmation = document.getElementById('password_confirmation');
        const passwordMatchError = document.getElementById('password-match-error');
        const registerButton = document.getElementById('register-button');

        function validatePasswords() {
            if (password.value && passwordConfirmation.value) {
                if (password.value !== passwordConfirmation.value) {
                    password.classList.add('border-red-500', 'dark:border-red-500');
                    passwordConfirmation.classList.add('border-red-500', 'dark:border-red-500');
                    passwordMatchError.classList.remove('hidden');
                    registerButton.disabled = true;
                    registerButton.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    password.classList.remove('border-red-500', 'dark:border-red-500');
                    passwordConfirmation.classList.remove('border-red-500', 'dark:border-red-500');
                    passwordMatchError.classList.add('hidden');
                    registerButton.disabled = false;
                    registerButton.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            }
        }

        password.addEventListener('input', validatePasswords);
        passwordConfirmation.addEventListener('input', validatePasswords);
    </script>
</x-guest-layout>
