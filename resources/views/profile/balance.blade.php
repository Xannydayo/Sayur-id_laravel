<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Balance') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4">Current Balance</h3>
                        <div class="bg-gray-100 p-4 rounded-lg">
                            <p class="text-2xl font-bold">Rp {{ number_format($user->balance, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    @if(auth()->user()->is_admin)
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold mb-4">Top Up Balance</h3>
                            <form action="{{ route('balance.topup') }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="user_id" class="block text-sm font-medium text-gray-700">User</label>
                                    <select name="user_id" id="user_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        @foreach(\App\Models\User::where('is_admin', false)->get() as $u)
                                            <option value="{{ $u->id }}">{{ $u->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="amount" class="block text-sm font-medium text-gray-700">Amount (Rp)</label>
                                    <input type="number" name="amount" id="amount" min="10000" step="1000" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                        Top Up
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif

                    <div class="mt-8">
                        <h3 class="text-lg font-semibold mb-4">Transaction History</h3>
                        <div class="bg-white shadow overflow-hidden sm:rounded-md">
                            <ul class="divide-y divide-gray-200">
                                @foreach($user->orders()->where('payment_method', 'balance')->get() as $order)
                                    <li class="px-4 py-4">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">Order #{{ $order->id }}</p>
                                                <p class="text-sm text-gray-500">{{ $order->created_at->format('d M Y H:i') }}</p>
                                            </div>
                                            <div class="text-sm text-gray-900">
                                                -Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 