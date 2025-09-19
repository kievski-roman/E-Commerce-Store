<x-app-layout>
    <div class="relative flex min-h-screen flex-col justify-center overflow-hidden bg-gray- py-6 sm:py-12">
        <div class="mx-auto max-w-screen-xl px-4 w-full">
            <div class="grid w-full sm:grid-cols-2 xl:grid-cols-4 gap-6">
                <!-- component -->
                @foreach($products as $product)


                    <div class="relative flex flex-col shadow-md rounded-xl overflow-hidden hover:shadow-lg hover:-translate-y-1 transition-all duration-300 max-w-sm">
                        <div class="max-w-sm w-full bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all">
                            <div class="relative">
                                <img
                                    src="https://placehold.co/400x300"
                                    alt="Product"
                                    class="w-full h-52 object-cover"
                                />
                            </div>

                            <div class="p-5 space-y-4">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900">{{$product->name}}</h3>
                                    <p class="text-gray-500 mt-1">{{$product->description}}</p>
                                </div>

                                <div class="flex justify-between items-center">
                                    <div class="space-y-1">
                                        <p class="text-2xl font-bold text-gray-900">{{$product->price }}</p>
                                        <p class="text-sm text-gray-500 line-through">{{$product->price}}</p>
                                    </div>

                                    <div class="flex items-center gap-1">
                                        <div class="text-yellow-400">★★★★</div>
                                        <div class="text-gray-300">★</div>
                                        <span class="text-sm text-gray-600 ml-1">(42)</span>
                                    </div>
                                </div>
                                <!-- component -->
                                <label for="custom-input-number" class="w-fit text-gray-700 text-sm font-semibold">Quantity :
                                    {{$product->quantity}}
                                </label>
                                <div class="flex justify-between items-center">
                                    <a href="{{route('admin.product.edit', $product->id)}}"
                                       class="w-24 text-center bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-3 rounded-lg transition-colors">
                                        Update
                                    </a>
                                    <form action="{{ route('admin.product.destroy',$product) }}" method="POST" enctype="multipart/form-data" >
                                        @csrf
                                        @method('DELETE')
                                    <button type="submit" class="w-24 text-center bg-red-600 hover:bg-red-700 text-white font-medium py-3 rounded-lg transition-colors">
                                        delete
                                    </button>
                                    </form>
                                </div>


                            </div>


                        </div>
                    </div>
                @endforeach

            </div>
            <div class="max-w-60 py-4" >
                {{$products->links()}}
            </div>
        </div>


    </div>
</x-app-layout>

