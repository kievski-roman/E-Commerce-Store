<x-app-layout>
    <div class="min-w-screen min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-center justify-between gap-3 mb-6">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900">Your Orders</h1>
                {{-- Место под фильтры/поиск, если добавишь --}}
                {{-- <div class="w-full md:w-80">
                    <input type="search" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" placeholder="Search by ID…">
                </div> --}}
            </div>

            <div class="w-full bg-white border border-gray-200 rounded-2xl p-5 sm:p-6 text-gray-900 shadow-sm">
                @if ($orders->isEmpty())
                    <div class="rounded-xl border border-dashed border-gray-200 bg-gray-50 p-12 text-center">
                        <p class="text-base text-gray-600">You have no orders yet.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 gap-5">
                        @foreach ($orders as $order)
                            @php
                                $statusColors = [
                                    'pending' => 'bg-amber-50 text-amber-700 ring-amber-200',
                                    'processing' => 'bg-blue-50 text-blue-700 ring-blue-200',
                                    'shipped' => 'bg-indigo-50 text-indigo-700 ring-indigo-200',
                                    'delivered' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
                                    'canceled' => 'bg-rose-50 text-rose-700 ring-rose-200',
                                ];
                                $statusKey = strtolower($order->status ?? 'pending');
                                $statusClass = $statusColors[$statusKey] ?? 'bg-gray-50 text-gray-700 ring-gray-200';

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

                            <div class="border border-gray-200 rounded-2xl p-4 sm:p-5">
                                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 mb-3">
                                    <div class="space-y-1">
                                        <h2 class="text-xl font-semibold text-gray-900">Order #{{ $order->id }}</h2>
                                        <p class="text-sm text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium ring-1 ring-inset {{ $statusClass }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium ring-1 ring-inset {{ $payClass }}">
                                            {{ ucfirst($order->payment_method) }}
                                        </span>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="space-y-1 text-sm">
                                        <p><span class="text-gray-500">Total:</span> <span class="font-semibold text-blue-700">RM {{ number_format($order->total_price, 2) }}</span></p>
                                        <p><span class="text-gray-500">Items:</span> <span class="font-medium">{{ $order->items->sum('quantity') }}</span></p>
                                    </div>

                                    <div class="text-sm">
                                        @if($order->address)
                                            <p class="text-gray-500 mb-1">Address:</p>
                                            <p class="font-medium text-gray-800">
                                                {{ $order->address->name }},
                                                {{ $order->address->address_line }},
                                                {{ $order->address->city }},
                                                {{ $order->address->country }}
                                            </p>
                                        @else
                                            <p class="text-gray-500 italic">No address provided</p>
                                        @endif
                                    </div>
                                </div>

                                {{-- Items quick peek --}}
                                <div class="mt-4 py-4">
                                    <h3 class="font-semibold text-gray-900">Items</h3>
                                    <ul class="mt-2 grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm text-gray-700">
                                        @foreach ($order->items->take(4) as $item)
                                            <li class="flex items-center gap-2">
                                                @if($item->product?->image_url)
                                                    <img src="{{ $item->product->image_url }}" class="w-10 h-10 rounded-lg object-cover ring-1 ring-gray-200" alt="">
                                                @else
                                                    <span class="w-10 h-10 rounded-lg bg-gray-100 ring-1 ring-gray-200 inline-block"></span>
                                                @endif
                                                <span class="min-w-0 truncate">
                                                    {{ $item->product->name ?? 'Product' }} — {{ $item->quantity }} × RM {{ number_format($item->price ?? $item->unit_price, 2) }}
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @if($order->items->count() > 4)
                                        <p class="mt-2 text-xs text-gray-500">…and {{ $order->items->count() - 4 }} more</p>
                                    @endif
                                </div>

                                <div class="mt-5  flex items-center justify-between">
                                    <a href="{{ route('order.show', $order->id) }}"
                                       class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 focus-visible:ring-offset-2">
                                        View details
                                    </a>
                                    {{-- место под actions: отмена/повторить --}}
                                    {{-- <form method="POST" action="{{ route('orders.repeat', $order->id) }}">@csrf
                                        <button class="inline-flex items-center gap-2 rounded-lg bg-white px-4 py-2 text-sm font-semibold text-gray-700 ring-1 ring-gray-200 hover:bg-gray-50">
                                            Re-order
                                        </button>
                                    </form> --}}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-8">
                        {{ $orders->onEachSide(1)->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
