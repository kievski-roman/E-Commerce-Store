<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
        <h1 class="text-2xl font-bold mb-4">Create Product</h1>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.product.store') }}"
              method="POST"
              enctype="multipart/form-data"
              class="bg-white shadow-md p-6 rounded-lg">
            @csrf
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full px-3 mb-6">
                    <label class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2"
                           for="name">Name Product</label>
                    <input class="appearance-none block w-full bg-white text-gray-900 font-medium border border-gray-400 rounded-lg py-3 px-3 leading-tight focus:outline-none focus:border-[#98c01d]"
                           type="text"
                           name="name"
                           value="{{ old('name') }}"
                           required/>
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="w-full px-3 mb-6">
                    <label class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2"
                           for="description">Description</label>
                    <textarea rows="4"
                              class="appearance-none block w-full bg-white text-gray-900 font-medium border border-gray-400 rounded-lg py-3 px-3 leading-tight focus:outline-none focus:border-[#98c01d]"
                              name="description"
                              required>{{ old('description') }}</textarea>
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="w-full px-3 mb-6">
                    <label class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2"
                           for="quantity">Quantity</label>
                    <div x-data="{ count: {{ old('quantity', 1) }} }"
                         class="custom-number-input flex items-center">
                        <button type="button"
                                @click="count--"
                                class="bg-gray-300 text-gray-600 hover:text-gray-700 hover:bg-gray-400 h-10 w-10 rounded-l cursor-pointer">
                            -
                        </button>
                        <input type="number"
                               name="quantity"
                               x-model="count"
                               class="border px-3 py-2 w-20 text-center bg-gray-300"
                               required/>
                        <button type="button"
                                @click="count++"
                                class="bg-gray-300 text-gray-600 hover:text-gray-700 hover:bg-gray-400 h-10 w-10 rounded-r cursor-pointer">
                            +
                        </button>
                    </div>
                    @error('quantity') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="w-full px-3 mb-6">
                    <label class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2"
                           for="price">Price</label>
                    <div x-data="{ count: {{ old('price', 0) }} }"
                         class="custom-number-input flex items-center">
                        <button type="button"
                                @click="count--"
                                class="bg-gray-300 text-gray-600 hover:text-gray-700 hover:bg-gray-400 h-10 w-10 rounded-l cursor-pointer">
                            -
                        </button>
                        <input type="number"
                               name="price"
                               x-model="count"
                               class="border px-3 py-2 w-20 text-center bg-gray-300"
                               required/>
                        <button type="button"
                                @click="count++"
                                class="bg-gray-300 text-gray-600 hover:text-gray-700 hover:bg-gray-400 h-10 w-10 rounded-r cursor-pointer">
                            +
                        </button>
                    </div>
                    @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="w-full px-3 mb-6">
                    <label class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2"
                           for="image">Product Image</label>
                    <input id="dropzone-file"
                           type="file"
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100"
                           name="image"
                           accept="image/png,image/jpeg,image/webp"/>
                    @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="w-full px-3 mb-6">
                    <button type="submit"
                            class="block w-full bg-green-700 text-gray-100 font-bold border border-gray-200 rounded-lg py-3 px-3 leading-tight hover:bg-green-600 focus:outline-none focus:bg-white focus:border-gray-500">
                        Create
                    </button>
                </div>
            </div>
        </form>
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
        value--;
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
