<x-app-layout>
    <div class="max-w-5xl mx-auto mt-8 px-6">
        <h1 class="text-3xl font-semibold mb-6">🧾 Order #{{ $order->id }}</h1>

        {{-- Основная информация --}}
        <div class="bg-white shadow rounded-2xl p-6 mb-8 border border-gray-100">
            <h2 class="text-xl font-semibold mb-4">Order Details</h2>
            <div class="grid grid-cols-2 gap-4 text-gray-700">
                <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                <p><strong>Payment:</strong> {{ ucfirst($order->payment_method) }}</p>
                <p><strong>Created at:</strong> {{ $order->created_at->format('d M Y, H:i') }}</p>
                <p><strong>Total:</strong> €{{ number_format($order->total_price, 2) }}</p>
            </div>
        </div>

        {{-- Адрес доставки --}}
        @if($order->address)
            <div class="bg-white shadow rounded-2xl p-6 mb-8 border border-gray-100">
                <h2 class="text-xl font-semibold mb-4">Shipping Address</h2>
                <div class="text-gray-700 leading-relaxed">
                    <p>{{ $order->address->name ?? '-' }}</p>
                    <p>{{ $order->address->address_line ?? '-' }}, {{ $order->address->city ?? '-' }}</p>
                    <p>{{ $order->address->postal_code ?? '-' }}, {{ $order->address->country ?? '-' }}</p>
                </div>
            </div>
        @endif

        {{-- Товары --}}
        <div class="bg-white shadow rounded-2xl p-6 border border-gray-100">
            <h2 class="text-xl font-semibold mb-4">Items</h2>
            <table class="w-full border-collapse">
                <thead>
                <tr class="border-b bg-gray-50 text-left text-gray-600 uppercase text-sm">
                    <th class="py-2 px-3">Product</th>
                    <th class="py-2 px-3">Price</th>
                    <th class="py-2 px-3">Qty</th>
                    <th class="py-2 px-3 text-right">Subtotal</th>
                </tr>
                </thead>
                <tbody class="divide-y">
                @forelse($order->items as $item)
                    <tr>
                        <td class="py-2 px-3">
                            <div class="flex items-center space-x-3">
                                @if($item->product?->image_url)
                                    <img src="{{ $item->product->image_url }}" class="w-12 h-12 rounded-lg object-cover" alt="">
                                @endif
                                <span>{{ $item->product?->name ?? $item->product_name ?? 'Unknown Product' }}</span>
                            </div>
                        </td>
                        <td class="py-2 px-3">€{{ number_format($item->unit_price, 2) }}</td>
                        <td class="py-2 px-3">{{ $item->quantity }}</td>
                        <td class="py-2 px-3 text-right font-medium">
                            €{{ number_format($item->unit_price * $item->quantity, 2) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-gray-500">No items found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <div class="text-right mt-4 font-semibold text-lg">
                Total: €{{ number_format($order->total_price, 2) }}
            </div>
        </div>
    </div>
</x-app-layout>
