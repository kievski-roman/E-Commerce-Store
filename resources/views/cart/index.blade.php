<x-app-layout>
    <section class="h-screen bg-gray-100 px-4 text-gray-600 antialiased">
        <div class="flex h-full flex-col justify-center">
            <div class="mx-auto w-full max-w-2xl rounded-sm border border-gray-200 bg-white shadow-lg">
                <header class="border-b border-gray-100 px-5 py-4">
                    <div class="font-semibold text-gray-800">Manage Carts</div>
                </header>

                <div class="overflow-x-auto p-3">
                    @if (session('success'))
                        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if (!empty($cart))
                        <table class="w-full table-auto">
                            <thead class="bg-gray-50 text-xs font-semibold uppercase text-gray-400">
                            <tr>
                                <th class="p-2"></th>
                                <th class="p-2">
                                    <div class="text-left font-semibold">Product Name</div>
                                </th>
                                <th class="p-2">
                                    <div class="text-left font-semibold">Quantity</div>
                                </th>
                                <th class="p-2">
                                    <div class="text-left font-semibold">Total</div>
                                </th>
                                <th class="p-2">
                                    <div class="text-center font-semibold">Action</div>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm">
                            @foreach ($products as $product)
                                <tr>
                                    <td class="p-2"></td>
                                    <td class="p-2">
                                        <div class="font-medium text-gray-800">{{ $product->name }}</div>
                                    </td>
                                    <td class="p-2">
                                        <div class="text-left">{{ $cart[$product->id]['quantity'] }}</div>
                                    </td>
                                    <td class="p-2">
                                        <div class="text-left font-medium text-green-500">
                                            RM {{ $cart[$product->id]['quantity'] * $product->price }}
                                        </div>
                                    </td>
                                    <td class="p-2">
                                        <div class="flex justify-center">
                                            <form action="{{ route('cart.remove', $product->id) }}" method="POST">
                                                @csrf
                                                <input type="submit" value="Remove" class="text-red-500 hover:text-red-700" />
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <form action="{{ route('cart.clear') }}" method="POST" class="mt-4 px-5" id="clear-cart-form">
                            @csrf
                            <input type="submit" value="Clear Cart" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600"
                                   onclick="return confirm('Are you sure you want to clear the cart?')" />
                        </form>
                    @else
                        <p class="text-center text-gray-500">Your cart is empty.</p>
                    @endif
                </div>
                @if (!empty($cart))
                    <form action="{{ route('checkout.index') }}" method="get" class="mt-4 px-5" id="clear-cart-form">
                        @csrf
                        <input type="submit" value="checkout" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-900"
                                />
                    </form>
                @endif
                @if (!empty($cart))
                    <div class="flex justify-end space-x-4 border-t border-gray-100 px-5 py-4 text-2xl font-bold">
                        <div>Total</div>
                        <div class="text-blue-600">RM <span>{{ $total }}</span></div>
                    </div>
                @endif
            </div>
        </div>
    </section>
</x-app-layout>
