<x-app-layout>
    <style>@import url('https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.3.45/css/materialdesignicons.min.css');</style>
    <style>
        .form-radio {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
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

        @media not print {
            .form-radio::-ms-check {
                border-width: 1px;
                color: transparent;
                background: inherit;
                border-color: inherit;
                border-radius: inherit;
            }
        }

        .form-radio:focus {
            outline: none;
        }

        .form-select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23a0aec0'%3e%3cpath d='M15.3 9.3a1 1 0 0 1 1.4 1.4l-4 4a1 1 0 0 1-1.4 0l-4-4a1 1 0 0 1 1.4-1.4l3.3 3.29 3.3-3.3z'/%3e%3c/svg%3e");
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
            background-repeat: no-repeat;
            padding-top: 0.5rem;
            padding-right: 2.5rem;
            padding-bottom: 0.5rem;
            padding-left: 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            background-position: right 0.5rem center;
            background-size: 1.5em 1.5em;
        }

        .form-select::-ms-expand {
            color: #a0aec0;
            border: none;
        }

        @media not print {
            .form-select::-ms-expand {
                display: none;
            }
        }

        @media print and (-ms-high-contrast: active), print and (-ms-high-contrast: none) {
            .form-select {
                padding-right: 0.75rem;
            }
        }
    </style>

    <div class="min-w-screen min-h-screen bg-gray-50 py-5">
        <div class="px-5">
            <div class="mb-2">
                <a href="{{ route('cart.index') }}"
                   class="focus:outline-none hover:underline text-gray-500 text-sm">
                    <i class="mdi mdi-arrow-left text-gray-400"></i>Back to Cart
                </a>
            </div>
            <div class="mb-2">
                <h1 class="text-3xl md:text-5xl font-bold text-gray-600">Checkout</h1>
            </div>
            <div class="mb-5 text-gray-400">
                <a href="{{ route('product.index') }}"
                   class="focus:outline-none hover:underline text-gray-500">Home</a> /
                <a href="{{ route('cart.index') }}"
                   class="focus:outline-none hover:underline text-gray-500">Cart</a> /
                <span class="text-gray-600">Checkout</span>
            </div>
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
                                            <img src="{{ $product->image_url ?? 'https://via.placeholder.com/150' }}"
                                                 alt="{{ $product->name }}">
                                        </div>
                                        <div class="flex-grow pl-3">
                                            <h6 class="font-semibold uppercase text-gray-600">{{ $product->name }}</h6>
                                            <p class="text-gray-400">x {{ $cart[$product->id]['quantity'] }}</p>
                                        </div>
                                        <div>
                                            <span class="font-semibold text-gray-600 text-xl">
                                                RM {{ number_format($cart[$product->id]['quantity'] * $product->price, 2) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="mb-6 pb-6 border-b border-gray-200">
                                <div class="-mx-2 flex items-end justify-end">
                                    <div class="flex-grow px-2 lg:max-w-xs">
                                        <label class="text-gray-600 font-semibold text-sm mb-2 ml-1">Discount
                                            code</label>
                                        <div>
                                            <input name="discount_code"
                                                   class="w-full px-3 py-2 border border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors"
                                                   placeholder="XXXXXX"
                                                   type="text"/>
                                        </div>
                                    </div>
                                    <div class="px-2">
                                        <button class="block w-full max-w-xs mx-auto border border-transparent bg-gray-400 hover:bg-gray-500 focus:bg-gray-500 text-white rounded-md px-5 py-2 font-semibold">
                                            APPLY
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-6 pb-6 border-b border-gray-200 text-gray-800">
                                <div class="w-full flex mb-3 items-center">
                                    <div class="flex-grow">
                                        <span class="text-gray-600">Subtotal</span>
                                    </div>
                                    <div class="pl-3">
                                        <span class="font-semibold">RM {{ number_format($total, 2) }}</span>
                                    </div>
                                </div>
                                <div class="w-full flex items-center">
                                    <div class="flex-grow">
                                        <span class="text-gray-600">Taxes (GST 10%)</span>
                                    </div>
                                    <div class="pl-3">
                                        <span class="font-semibold">RM {{ number_format($total * 0.1, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-6 pb-6 border-b border-gray-200 md:border-none text-gray-800 text-xl">
                                <div class="w-full flex items-center">
                                    <div class="flex-grow">
                                        <span class="text-gray-600">Total</span>
                                    </div>
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
                        <form action="{{ route('checkout.store') }}"
                              method="POST">
                            @csrf
                            <div class="w-full mx-auto rounded-lg bg-white border border-gray-200 p-3 text-gray-800 font-light mb-6">
                                <div class="w-full flex mb-3 items-center">
                                    <div class="w-32">
                                        <span class="text-gray-600 font-semibold">Contact</span>
                                    </div>
                                    <div class="flex-grow pl-3">
                                        <input name="name"
                                               value="{{ old('name', Auth::user()?->name) }}"
                                               class="w-full px-3 py-2 border border-gray-200 rounded-md focus:outline-none focus:border-indigo-500"
                                               placeholder="Full Name"
                                               type="text"
                                               required/>
                                    </div>
                                </div>
                                <div class="w-full flex mb-3 items-center">
                                    <div class="w-32">
                                        <span class="text-gray-600 font-semibold">Email</span>
                                    </div>
                                    <div class="flex-grow pl-3">
                                        <input name="email"
                                               value="{{ old('email', Auth::user()?->email) }}"
                                               class="w-full px-3 py-2 border border-gray-200 rounded-md focus:outline-none focus:border-indigo-500"
                                               placeholder="Email"
                                               type="email"
                                               required/>
                                    </div>
                                </div>
                                <div class="w-full flex items-center">
                                    <div class="w-32">
                                        <span class="text-gray-600 font-semibold">Billing Address</span>
                                    </div>
                                    <div class="flex-grow pl-3">
                                        <input name="address_line"
                                               value="{{ old('address_line') }}"
                                               class="w-full px-3 py-2 mb-1 border border-gray-200 rounded-md focus:outline-none focus:border-indigo-500"
                                               placeholder="Street Address"
                                               type="text"
                                               required/>
                                        <input name="city"
                                               value="{{ old('city') }}"
                                               class="w-full px-3 py-2 mb-1 border border-gray-200 rounded-md focus:outline-none focus:border-indigo-500"
                                               placeholder="City"
                                               type="text"
                                               required/>
                                        <input name="state"
                                               value="{{ old('state') }}"
                                               class="w-full px-3 py-2 mb-1 border border-gray-200 rounded-md focus:outline-none focus:border-indigo-500"
                                               placeholder="State (optional)"
                                               type="text"/>
                                        <input name="postal_code"
                                               value="{{ old('postal_code') }}"
                                               class="w-full px-3 py-2 mb-1 border border-gray-200 rounded-md focus:outline-none focus:border-indigo-500"
                                               placeholder="Postal Code"
                                               type="text"/>
                                        <input name="country"
                                               value="{{ old('country', 'Malaysia') }}"
                                               class="w-full px-3 py-2 mb-1 border border-gray-200 rounded-md focus:outline-none focus:border-indigo-500"
                                               placeholder="Country"
                                               type="text"
                                               required/>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full mx-auto rounded-lg bg-white border border-gray-200 text-gray-800 font-light mb-6">
                                <div class="w-full p-3 border-b border-gray-200">
                                    <div class="mb-5">
                                        <label for="type1"
                                               class="flex items-center cursor-pointer">
                                            <input type="radio"
                                                   class="form-radio h-5 w-5 text-indigo-500"
                                                   name="payment_method"
                                                   id="type1"
                                                   value="card"
                                                   checked>
                                            <img src="https://leadershipmemphis.org/wp-content/uploads/2020/08/780370.png"
                                                 class="h-6 ml-3">
                                        </label>
                                    </div>
                                    <div>
                                        <div class="mb-3">
                                            <label class="text-gray-600 font-semibold text-sm mb-2 ml-1">Name on
                                                card</label>
                                            <div>
                                                <input name="card_name"
                                                       class="w-full px-3 py-2 mb-1 border border-gray-200 rounded-md focus:outline-none focus:border-indigo-500"
                                                       placeholder="John Smith"
                                                       type="text"/>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-gray-600 font-semibold text-sm mb-2 ml-1">Card
                                                number</label>
                                            <div>
                                                <input name="card_number"
                                                       class="w-full px-3 py-2 mb-1 border border-gray-200 rounded-md focus:outline-none focus:border-indigo-500"
                                                       placeholder="0000 0000 0000 0000"
                                                       type="text"/>
                                            </div>
                                        </div>
                                        <div class="mb-3 -mx-2 flex items-end">
                                            <div class="px-2 w-1/4">
                                                <label class="text-gray-600 font-semibold text-sm mb-2 ml-1">Expiration
                                                    date</label>
                                                <select name="card_exp_month"
                                                        class="form-select w-full px-3 py-2 mb-1 border border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 cursor-pointer">
                                                    <option value="01">01 - January</option>
                                                    <option value="02">02 - February</option>
                                                    <option value="03">03 - March</option>
                                                    <option value="04">04 - April</option>
                                                    <option value="05">05 - May</option>
                                                    <option value="06">06 - June</option>
                                                    <option value="07">07 - July</option>
                                                    <option value="08">08 - August</option>
                                                    <option value="09">09 - September</option>
                                                    <option value="10">10 - October</option>
                                                    <option value="11">11 - November</option>
                                                    <option value="12">12 - December</option>
                                                </select>
                                            </div>
                                            <div class="px-2 w-1/4">
                                                <select name="card_exp_year"
                                                        class="form-select w-full px-3 py-2 mb-1 border border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 cursor-pointer">
                                                    <option value="2025">2025</option>
                                                    <option value="2026">2026</option>
                                                    <option value="2027">2027</option>
                                                    <option value="2028">2028</option>
                                                    <option value="2029">2029</option>
                                                </select>
                                            </div>
                                            <div class="px-2 w-1/4">
                                                <label class="text-gray-600 font-semibold text-sm mb-2 ml-1">Security
                                                    code</label>
                                                <input name="card_cvc"
                                                       class="w-full px-3 py-2 mb-1 border border-gray-200 rounded-md focus:outline-none focus:border-indigo-500"
                                                       placeholder="000"
                                                       type="text"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full p-3">
                                    <label for="type2"
                                           class="flex items-center cursor-pointer">
                                        <input type="radio"
                                               class="form-radio h-5 w-5 text-indigo-500"
                                               name="payment_method"
                                               id="type2"
                                               value="paypal">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg"
                                             width="80"
                                             class="ml-3"/>
                                    </label>
                                </div>
                                <div class="w-full p-3">
                                    <label for="type3"
                                           class="flex items-center cursor-pointer">
                                        <input type="radio"
                                               class="form-radio h-5 w-5 text-indigo-500"
                                               name="payment_method"
                                               id="type3"
                                               value="cash">
                                        <span class="ml-3 text-gray-600 font-semibold">Cash on Delivery</span>
                                    </label>
                                </div>
                            </div>
                            <div>
                                <button type="submit"
                                        class="w-full max-w-xs mx-auto bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-900 font-semibold">
                                    <i class="mdi mdi-lock-outline mr-1"></i> PAY NOW
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
