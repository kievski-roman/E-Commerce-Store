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
                            <form action="{{route('cart.add',$product->id)}}"
                                  method="POST">
                                @csrf
                                <div class="p-5 space-y-4">
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900">{{$product->name}}</h3>
                                        <p class="text-gray-500 mt-1">{{$product->description}}</p>
                                    </div>

                                    <div class="flex justify-between items-center">
                                        <div class="space-y-1">
                                            <p name="price"
                                               class="text-2xl font-bold text-gray-900">{{$product->price}}</p>
                                            <p class="text-sm text-gray-500 line-through">{{$product->price}}</p>
                                        </div>

                                        <div class="flex items-center gap-1">
                                            <div class="text-yellow-400">★★★★</div>
                                            <div class="text-gray-300">★</div>
                                            <span class="text-sm text-gray-600 ml-1">(42)</span>
                                        </div>
                                    </div>

                                    <!-- component -->
                                    <p class="w-full text-gray-700 text-sm font-semibold">Max :
                                        {{$product->quantity}}
                                    </p>
                                    <div class="custom-number-input h-10 w-32">

                                        <div class="flex flex-row h-10 w-full rounded-lg relative bg-transparent mb-5">
                                            <button type="button"
                                                    data-action="decrement"
                                                    class=" bg-gray-300 text-gray-600 hover:text-gray-700 hover:bg-gray-400 h-full w-20 rounded-l cursor-pointer outline-none">
                                                <span class="m-auto text-2xl font-thin">−</span>
                                            </button>

                                            <input name="quantity"
                                                   type="number"
                                                   class="outline-none focus:outline-none text-center w-full bg-gray-300 font-semibold text-md hover:text-black focus:text-black  md:text-basecursor-default flex items-center text-gray-700  outline-none"
                                                   value="1"></input>

                                            <button type="button"
                                                    data-action="increment"
                                                    class="bg-gray-300 text-gray-600 hover:text-gray-700 hover:bg-gray-400 h-full w-20 rounded-r cursor-pointer">
                                                <span class="m-auto text-2xl font-thin">+</span>
                                            </button>
                                        </div>
                                    </div>


                                    <button type="submit"
                                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-3 rounded-lg transition-colors">
                                        Add to Cart
                                    </button>

                                </div>
                            </form>
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


<style>
    input[type='number']::-webkit-inner-spin-button,
    input[type='number']::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .custom-number-input input:focus {
        outline: none !important;
    }

    .custom-number-input button:focus {
        outline: none !important;
    }
</style>

<script>
    function decrement(e) {
        const btn = e.target.parentNode.parentElement.querySelector(
            'button[data-action="decrement"]'
        );
        const target = btn.nextElementSibling;
        let value = Number(target.value);
        if (value > 1) value--;
        target.value = value;
    }

    function increment(e) {
        const btn = e.target.parentNode.parentElement.querySelector(
            'button[data-action="decrement"]'
        );
        const target = btn.nextElementSibling;
        let value = Number(target.value);
        value++;
        target.value = value;
    }

    const decrementButtons = document.querySelectorAll(
        `button[data-action="decrement"]`
    );

    const incrementButtons = document.querySelectorAll(
        `button[data-action="increment"]`
    );

    decrementButtons.forEach(btn => {
        btn.addEventListener("click", decrement);
    });

    incrementButtons.forEach(btn => {
        btn.addEventListener("click", increment);
    });
</script>
