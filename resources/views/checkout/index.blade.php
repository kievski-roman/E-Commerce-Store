<x-app-layout>
    <style>@import url('https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.3.45/css/materialdesignicons.min.css')</style>
    <style>
        .form-radio {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            display: inline-block;
            vertical-align: middle;
            background-origin: border-box;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            flex-shrink: 0;
            border-radius: 100%;
            border-width: 2px;
        }
        .form-radio:checked {
            background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3ccircle cx='8' cy='8' r='3'/%3e%3c/svg%3e");
            border-color: transparent;
            background-color: currentColor;
            background-size: 100% 100%;
            background-position: center;
            background-repeat: no-repeat;
        }
        .form-radio:focus {
            outline: none;
        }
    </style>

    <div class="min-w-screen min-h-screen bg-gray-50 py-5">
        <div class="px-5">
            <div class="mb-2">
                <a href="{{ route('cart.index') }}" class="focus:outline-none hover:underline text-gray-500 text-sm"><i class="mdi mdi-arrow-left text-gray-400"></i>Back to Cart</a>
            </div>
            <h1 class="text-3xl md:text-5xl font-bold text-gray-600">Checkout</h1>
        </div>
        <div class="w-full bg-white border-t border-b border-gray-200 px-5 py-10 text-gray-800">
            <div class="w-full">
                <div class="-mx-3 md:flex items-start">
                    <div class="px-3 md:w-7/12 lg:pr-10">
                        @if (!empty($cart))
                            @foreach ($products as $product)
                                <div class="w-full mx-auto text-gray-800 font-light mb-6 border-b border-gray-200 pb-6">
                                    <div class="w-full flex items-center">
                                        <div class="overflow-hidden rounded-lg w-16 h-16 bg-gray-50 border border-gray-200">
                                            <img src="{{ $product->image ?? 'https://via.placeholder.com/150' }}" alt="{{ $product->name }}">
                                        </div>
                                        <div class="flex-grow pl-3">
                                            <h6 class="font-semibold uppercase text-gray-600">{{ $product->name }}</h6>
                                            <p class="text-gray-400">x {{ $cart[$product->id]['quantity'] }}</p>
                                        </div>
                                        <div>
                                            <span class="font-semibold text-gray-600 text-xl">RM {{ number_format($cart[$product->id]['quantity'] * $product->price, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="mb-6 pb-6 border-b border-gray-200 text-gray-800">
                                <div class="w-full flex mb-3 items-center">
                                    <div class="flex-grow"><span class="text-gray-600">Subtotal</span></div>
                                    <div class="pl-3"><span class="font-semibold">RM {{ number_format($total, 2) }}</span></div>
                                </div>
                                <div class="w-full flex items-center">
                                    <div class="flex-grow"><span class="text-gray-600">Taxes (GST 10%)</span></div>
                                    <div class="pl-3"><span class="font-semibold">RM {{ number_format($total * 0.1, 2) }}</span></div>
                                </div>
                            </div>
                            <div class="text-gray-800 text-xl">
                                <div class="w-full flex items-center">
                                    <div class="flex-grow"><span class="text-gray-600">Total</span></div>
                                    <div class="pl-3">
                                        <span class="font-semibold text-gray-400 text-sm">MYR</span>
                                        <span class="font-semibold">RM {{ number_format($total * 1.1, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        @else
                            <p class="text-center text-gray-500">Your cart is empty.</p>
                        @endif
                    </div>
                    <div class="px-3 md:w-5/12">
                        <form action="{{ route('checkout.store') }}" method="POST">
                            @csrf
                            <div class="w-full mx-auto rounded-lg bg-white border border-gray-200 p-3 text-gray-800 font-light mb-6">
                                <div class="mb-3">
                                    <label class="text-gray-600 font-semibold text-sm mb-2">Name</label>
                                    <input name="name" value="{{ old('name', Auth::user()?->name) }}" class="w-full px-3 py-2 border border-gray-200 rounded-md focus:outline-none focus:border-indigo-500" placeholder="John Smith" type="text" required />
                                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="text-gray-600 font-semibold text-sm mb-2">Email</label>
                                    <input name="email" value="{{ old('email', Auth::user()?->email) }}" class="w-full px-3 py-2 border border-gray-200 rounded-md focus:outline-none focus:border-indigo-500" placeholder="john@example.com" type="email" required />
                                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="text-gray-600 font-semibold text-sm mb-2">Address Line</label>
                                    <input name="address_line" value="{{ old('address_line') }}" class="w-full px-3 py-2 border border-gray-200 rounded-md focus:outline-none focus:border-indigo-500" placeholder="123 George Street" type="text" required />
                                    @error('address_line') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="text-gray-600 font-semibold text-sm mb-2">City</label>
                                    <input name="city" value="{{ old('city') }}" class="w-full px-3 py-2 border border-gray-200 rounded-md focus:outline-none focus:border-indigo-500" placeholder="Sydney" type="text" required />
                                    @error('city') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="text-gray-600 font-semibold text-sm mb-2">State</label>
                                    <input name="state" value="{{ old('state') }}" class="w-full px-3 py-2 border border-gray-200 rounded-md focus:outline-none focus:border-indigo-500" placeholder="NSW" type="text" />
                                    @error('state') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="text-gray-600 font-semibold text-sm mb-2">Postal Code</label>
                                    <input name="postal_code" value="{{ old('postal_code') }}" class="w-full px-3 py-2 border border-gray-200 rounded-md focus:outline-none focus:border-indigo-500" placeholder="2000" type="text" />
                                    @error('postal_code') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="text-gray-600 font-semibold text-sm mb-2">Country</label>
                                    <input name="country" value="{{ old('country', 'Malaysia') }}" class="w-full px-3 py-2 border border-gray-200 rounded-md focus:outline-none focus:border-indigo-500" placeholder="Malaysia" type="text" required />
                                    @error('country') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="text-gray-600 font-semibold text-sm mb-2">Payment Method</label>
                                    <div class="flex items-center mb-2">
                                        <input type="radio" class="form-radio h-5 w-5 text-indigo-500" name="payment_method" value="card" id="card" checked>
                                        <label for="card" class="ml-2">Credit Card</label>
                                    </div>
                                    <div class="flex items-center mb-2">
                                        <input type="radio" class="form-radio h-5 w-5 text-indigo-500" name="payment_method" value="paypal" id="paypal">
                                        <label for="paypal" class="ml-2">PayPal</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="radio" class="form-radio h-5 w-5 text-indigo-500" name="payment_method" value="cash" id="cash">
                                        <label for="cash" class="ml-2">Cash on Delivery</label>
                                    </div>
                                    @error('payment_method') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-900 font-semibold"><i class="mdi mdi-lock-outline mr-1"></i> Place Order</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
