<x-app-layout>
    <div class="min-w-screen min-h-screen bg-gray-50 py-5">
        <div class="px-5">
            <h1 class="text-3xl md:text-5xl font-bold text-gray-600">Admin Orders</h1>
        </div>
        <div class="w-full bg-white border-t border-b border-gray-200 px-5 py-10 text-gray-800">
            @if ($orders->isEmpty())
                <p class="text-center text-gray-500">You have no orders yet.</p>
            @else
                <div class="grid grid-cols-1 gap-6">
                    @foreach ($orders as $order)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex justify-between items-center mb-4">
                                <h2 class="text-xl font-semibold">Order #{{ $order->id }}</h2>
                                <span class="text-gray-500">{{ $order->created_at->format('d M Y') }}</span>
                            </div>
                            <div class="mb-4">
                                <p><strong>Total:</strong> RM {{ number_format($order->total_price, 2) }}</p>
                                <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                                <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
                            </div>
                            <div class="mb-4">
                                <p><strong>Address:</strong> {{ $order->address->name }}
                                    , {{ $order->address->address_line }}, {{ $order->address->city }}
                                    , {{ $order->address->country }}</p>
                            </div>
                            <div>
                                <h3 class="font-semibold">Items:</h3>
                                <ul class="list-disc pl-5">
                                    @foreach ($order->items as $item)
                                        <li>{{ $item->product->name }} - {{ $item->quantity }} x
                                            RM {{ number_format($item->price, 2) }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <a href="{{ route('order.show', $order->id) }}"
                               class="text-blue-600 hover:underline">View Details</a>
                            <a href="{{ route('admin.order.edit', $order->id) }}"
                               class="text-blue-600 hover:underline">edit</a>
                            <form action="{{route('admin.order.destroy',$order->id)}}"
                                  method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="w-24 text-center bg-red-600 hover:bg-red-700 text-white font-medium py-3 rounded-lg transition-colors">
                                    delete
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

