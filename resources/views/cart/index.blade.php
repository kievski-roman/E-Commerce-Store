<x-app-layout>
    <section class="min-h-screen bg-gray-100 px-4 sm:px-6 lg:px-8 text-gray-800 antialiased">
        <div class="mx-auto w-full max-w-7xl py-8">
            <div class="rounded-2xl border border-gray-200 bg-white shadow-sm ring-1 ring-black/5">
                <header class="border-b border-gray-100 px-6 py-5">
                    <h1 class="text-2xl font-semibold tracking-tight text-gray-900">Manage Carts</h1>
                </header>

                <div class="p-5 sm:p-6">
                    @if (session('success'))
                        <div class="mb-5 flex items-start gap-3 rounded-lg border border-green-200 bg-green-50 p-4 text-green-800" role="status" aria-live="polite">
                            <svg class="h-5 w-5 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16Zm3.707-9.707a1 1 0 00-1.414-1.414L9 10.172 7.707 8.879a1 1 0 00-1.414 1.414L9 13l4.707-4.707Z" clip-rule="evenodd"/>
                            </svg>
                            <p class="font-medium">{{ session('success') }}</p>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-5 flex items-start gap-3 rounded-lg border border-red-200 bg-red-50 p-4 text-red-700" role="alert" aria-live="assertive">
                            <svg class="h-5 w-5 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M18 10A8 8 0 11.001 9.999 8 8 0 0118 10zM9 5h2v6H9V5zm0 8h2v2H9v-2z" clip-rule="evenodd"/>
                            </svg>
                            <p class="font-medium">{{ session('error') }}</p>
                        </div>
                    @endif

                    @if (!empty($cart))
                        {{-- DESKTOP/TABLET TABLE --}}
                        <div class="hidden md:block">
                            <div class="overflow-x-auto rounded-xl border border-gray-100">
                                <table class="w-full table-auto text-[15px]">
                                    <thead class="bg-gray-50 text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    <tr>
                                        <th class="p-4 w-6"><span class="sr-only">#</span></th>
                                        <th class="p-4 text-left">Product Name</th>
                                        <th class="p-4 text-left">Quantity</th>
                                        <th class="p-4 text-left">Total</th>
                                        <th class="p-4 text-center">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                    @foreach ($products as $product)
                                        <tr class="group hover:bg-gray-50 transition-colors">
                                            <td class="p-4 w-6">
                                                <span class="inline-block h-1.5 w-1.5 rounded-full bg-gray-300 group-hover:bg-gray-400"></span>
                                            </td>
                                            <td class="p-4 max-w-[480px]">
                                                <div class="font-medium text-gray-900 truncate">{{ $product->name }}</div>
                                            </td>
                                            <td class="p-4">
                                                <span class="inline-flex min-w-[56px] justify-center rounded-md bg-gray-100 px-2.5 py-1 text-sm font-medium text-gray-700">{{ $cart[$product->id]['quantity'] }}</span>
                                            </td>
                                            <td class="p-4">
                                                <div class="font-semibold text-emerald-600">
                                                    RM {{ $cart[$product->id]['quantity'] * $product->price }}
                                                </div>
                                            </td>
                                            <td class="p-4">
                                                <div class="flex justify-center">
                                                    <form action="{{ route('cart.remove', $product->id) }}" method="POST">
                                                        @csrf
                                                        <button
                                                            type="submit"
                                                            class="inline-flex items-center gap-2 rounded-lg border border-red-300 bg-white px-4 py-2 text-sm md:text-base font-semibold text-red-600 shadow-sm transition hover:bg-red-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-400 focus-visible:ring-offset-2"
                                                            aria-label="Remove {{ $product->name }} from cart">
                                                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 100 2h.293l.823 9.053A2 2 0 007.108 17h5.784a2 2 0 001.992-1.947L15.707 6H16a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0010 2H9zm-1 6a1 1 0 112 0v6a1 1 0 11-2 0V8zm4 0a1 1 0 112 0v6a1 1 0 11-2 0V8z" clip-rule="evenodd"/>
                                                            </svg>
                                                            Remove
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- MOBILE CARDS --}}
                        <div class="space-y-4 md:hidden">
                            @foreach ($products as $product)
                                <div class="rounded-xl border border-gray-200 p-4 shadow-sm">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="min-w-0">
                                            <div class="text-base font-semibold text-gray-900 break-words">{{ $product->name }}</div>
                                            <div class="mt-2 flex flex-wrap items-center gap-3 text-sm text-gray-600">
                                                <span class="inline-flex min-w-[52px] justify-center rounded-md bg-gray-100 px-2 py-1 font-medium">x{{ $cart[$product->id]['quantity'] }}</span>
                                                <span class="font-semibold text-emerald-600">RM {{ $cart[$product->id]['quantity'] * $product->price }}</span>
                                            </div>
                                        </div>
                                        <form action="{{ route('cart.remove', $product->id) }}" method="POST" class="shrink-0">
                                            @csrf
                                            <button
                                                type="submit"
                                                class="inline-flex items-center gap-2 rounded-lg border border-red-300 bg-white px-3 py-1.5 text-sm font-semibold text-red-600 shadow-sm transition hover:bg-red-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-400 focus-visible:ring-offset-2">
                                                Remove
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- ACTIONS + TOTAL --}}
                        <div class="mt-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

                            <div class="text-2xl font-bold text-gray-900">
                                Total: <span class="text-blue-700">RM <span>{{ $total }}</span></span>
                            </div>
                            <div class="order-1 w-full md:order-2 flex justify-between gap-2 md:flex-row md:items-center md:gap-6">

                                <form action="{{ route('cart.clear') }}" method="POST" id="clear-cart-form" class=" order-2 md:w-auto">
                                    @csrf
                                    <button
                                        type="submit"
                                        class="inline-flex  md:w-auto items-center justify-center gap-2 rounded-lg bg-red-500 px-5 py-3 text-base font-semibold text-white shadow-sm transition hover:bg-red-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-400 focus-visible:ring-offset-2"
                                        onclick="return confirm('Are you sure you want to clear the cart?')">
                                        Clear Cart
                                    </button>
                                </form>
                                <form action="{{ route('checkout.index') }}" method="get" id="checkout-form" class=" md:w-auto">
                                    @csrf
                                    <button
                                        type="submit"
                                        class="inline-flex w-full md:w-auto items-center justify-center gap-2 rounded-lg bg-blue-600 px-6 py-3 text-base font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 focus-visible:ring-offset-2">
                                        Checkout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="rounded-xl border border-dashed border-gray-200 bg-gray-50 p-12 text-center">
                            <p class="text-base text-gray-600">Your cart is empty.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
