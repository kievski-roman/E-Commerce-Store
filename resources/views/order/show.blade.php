<x-app-layout>
    <div class="max-w-7xl mx-auto mt-8 px-6">
        {{-- Header + actions --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <h1 class="text-3xl font-semibold tracking-tight text-gray-300">🧾 Order #{{ $order->id }}</h1>

            <div class="flex flex-wrap items-center gap-3">
                @php
                    $statusColors = [
                        'pending' => 'bg-gray-100 text-gray-700 ring-gray-300',
                        'processing' => 'bg-blue-50 text-blue-700 ring-blue-200',
                        'shipped' => 'bg-indigo-50 text-indigo-700 ring-indigo-200',
                        'delivered' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
                        'canceled' => 'bg-rose-50 text-rose-700 ring-rose-200',
                    ];
                    $statusKey = strtolower($order->status ?? 'pending');
                    $statusClass = $statusColors[$statusKey] ?? 'bg-gray-100 text-gray-700 ring-gray-300';

                    $payColors = [
                        'card' => 'bg-purple-50 text-purple-700 ring-purple-200',
                        'cash' => 'bg-gray-100 text-gray-700 ring-gray-300',
                        'paypal' => 'bg-sky-50 text-sky-700 ring-sky-200',
                        'ideal' => 'bg-blue-50 text-blue-700 ring-blue-200',
                        'paid' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
                        'unpaid' => 'bg-amber-50 text-amber-700 ring-amber-200',
                    ];
                    $payKey = strtolower($order->payment_method ?? 'card');
                    $payClass = $payColors[$payKey] ?? 'bg-gray-50 text-gray-700 ring-gray-200';
                @endphp

                <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-medium ring-1 ring-inset {{ $statusClass }}">
                    Status: {{ ucfirst($order->status) }}
                </span>

                <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-medium ring-1 ring-inset {{ $payClass }}">
                    Payment: {{ ucfirst($order->payment_method) }}
                </span>

                <a href="{{ route('order.show', $order->id) }}"
                   class="inline-flex items-center gap-2 rounded-lg bg-white px-4 py-2 text-sm font-semibold text-gray-700 ring-1 ring-gray-200 hover:bg-gray-50">
                    Refresh
                </a>
                {{-- Пример вторичной кнопки под печать/инвойс (если будет роут) --}}
                {{-- <a href="{{ route('orders.invoice', $order->id) }}" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">Download invoice</a> --}}
            </div>
        </div>

        {{-- Summary --}}
        <div class="bg-white shadow-sm rounded-2xl p-6 mb-8 border border-gray-100">
            <h2 class="text-xl font-semibold mb-4 text-gray-900">Order Details</h2>
            <dl class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-gray-800">
                <div class="rounded-xl bg-gray-50 p-4 ring-1 ring-inset ring-gray-100">
                    <dt class="text-sm text-gray-500">Created at</dt>
                    <dd class="mt-1 font-medium">{{ $order->created_at->format('d M Y, H:i') }}</dd>
                </div>
                <div class="rounded-xl bg-gray-50 p-4 ring-1 ring-inset ring-gray-100">
                    <dt class="text-sm text-gray-500">Payment</dt>
                    <dd class="mt-1 font-medium">{{ ucfirst($order->payment_method) }}</dd>
                </div>
                <div class="rounded-xl bg-gray-50 p-4 ring-1 ring-inset ring-gray-100">
                    <dt class="text-sm text-gray-500">Items count</dt>
                    <dd class="mt-1 font-medium">{{ $order->items->sum('quantity') }}</dd>
                </div>
                <div class="rounded-xl bg-gray-50 p-4 ring-1 ring-inset ring-gray-100">
                    <dt class="text-sm text-gray-500">Total</dt>
                    <dd class="mt-1 text-lg font-bold text-blue-700">€{{ number_format($order->total_price, 2) }}</dd>
                </div>
            </dl>
        </div>
        @if($order->address)
            <div class="bg-white shadow-sm rounded-2xl p-6 mb-8 border border-gray-100">
                <h2 class="text-xl font-semibold mb-4 text-gray-900">Shipping Address</h2>
                <div class="text-gray-800 leading-relaxed">
                    <p class="font-medium">{{ $order->address->name ?? '-' }}</p>
                    <p>{{ $order->address->address_line ?? '-' }}</p>
                    <p>{{ $order->address->postal_code ?? '-' }} {{ $order->address->city ?? '-' }}</p>
                    <p>{{ $order->address->country ?? '-' }}</p>
                </div>
            </div>
        @endif

        {{-- Items table + mobile cards --}}
        {{-- Items table + mobile cards --}}
        <div class="bg-white shadow-sm rounded-2xl p-6 border border-gray-100">
            <div class="flex items-center justify-between gap-3 mb-4">
                <h2 class="text-xl font-semibold text-gray-900">Items</h2>
                <div class="text-right text-lg font-semibold text-gray-900 hidden md:block">
                    Total: <span class="text-blue-700">€{{ number_format($order->total_price, 2) }}</span>
                </div>
            </div>

            {{-- DESKTOP/TABLET (md+) --}}
            <div class="hidden md:block">
                <div class="rounded-xl ring-1 ring-inset ring-gray-100 overflow-x-auto">
                    <table class="w-full table-auto">
                        <thead class="bg-gray-50 text-xs font-semibold uppercase tracking-wide text-gray-600">
                        <tr>
                            <th class="py-3 px-4 text-left">Product</th>
                            <th class="py-3 px-4 text-left">Price</th>
                            <th class="py-3 px-4 text-left">Qty</th>
                            <th class="py-3 px-4 text-right">Subtotal</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($order->items as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-4">
                                    <div class="flex items-center gap-3">
                                        @if($item->product?->image_url)
                                            <img src="{{ $item->product->image_url }}" alt="" class="w-12 h-12 rounded-lg object-cover ring-1 ring-gray-200">
                                        @else
                                            <div class="w-12 h-12 rounded-lg bg-gray-100 ring-1 ring-gray-200"></div>
                                        @endif
                                        <div class="min-w-0">
                                            <div class="font-medium text-gray-900 truncate">
                                                {{ $item->product?->name ?? $item->product_name ?? 'Unknown Product' }}
                                            </div>
                                            @if(!empty($item->sku))
                                                <div class="text-xs text-gray-500">SKU: {{ $item->sku }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-4">€{{ number_format($item->unit_price ?? $item->price, 2) }}</td>
                                <td class="py-3 px-4">
                                <span class="inline-flex min-w-[44px] justify-center rounded-md bg-gray-100 px-2 py-1 font-medium">
                                    {{ $item->quantity }}
                                </span>
                                </td>
                                <td class="py-3 px-4 text-right font-semibold text-emerald-700">
                                    €{{ number_format(($item->unit_price ?? $item->price) * $item->quantity, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-6 text-gray-500">No items found.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- MOBILE (< md) --}}
            <div class="md:hidden space-y-3">
                @forelse($order->items as $item)
                    <div class="rounded-xl border border-gray-200 p-4">
                        <div class="flex items-center gap-3">
                            @if($item->product?->image_url)
                                <img src="{{ $item->product->image_url }}" alt="" class="w-14 h-14 rounded-lg object-cover ring-1 ring-gray-200">
                            @else
                                <div class="w-14 h-14 rounded-lg bg-gray-100 ring-1 ring-gray-200"></div>
                            @endif
                            <div class="min-w-0">
                                <div class="font-semibold text-gray-900 break-words">
                                    {{ $item->product?->name ?? $item->product_name ?? 'Unknown Product' }}
                                </div>
                                <div class="mt-1 text-sm text-gray-600">
                                    €{{ number_format($item->unit_price ?? $item->price, 2) }} · Qty: {{ $item->quantity }}
                                </div>
                            </div>
                            <div class="ml-auto text-right font-semibold text-emerald-700">
                                €{{ number_format(($item->unit_price ?? $item->price) * $item->quantity, 2) }}
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500 py-6">No items found.</p>
                @endforelse

                <div class="text-right mt-4 font-bold text-xl">
                    Total: €{{ number_format($order->total_price, 2) }}
                </div>
            </div>
        </div>
        </div>
    </div>
</x-app-layout>
