@extends('layouts.app')
@section('content')
    <section class="text-gray-600 body-font overflow-hidden">
        <div class="container px-5 py-24 mx-auto">
            <div>
                <a href="{{ route('products.index') }}" class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">Back</a>

            </div>
            <div class="lg:w-4/5 mx-auto flex flex-wrap">
                <img alt="ecommerce" class="lg:w-1/2 w-full lg:h-auto h-64 object-cover object-center rounded"
                     src="https://dummyimage.com/400x400">
                <div class="lg:w-1/2 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0">
                    <h1 class="text-gray-900 text-3xl title-font font-medium mb-1">{{ $product->product_name }}</h1>

                    <div class="leading-relaxed">
                        {!! $product->description !!}
                    </div>
                    @if($product_variants->count() > 0)
                    <div class="flex mt-6 items-center pb-5 border-b-2 border-gray-100 mb-5">
                        <div class="flex ml-6 items-center">
                            <span class="mr-3">Variant</span>
                            <div class="relative">
                                <select id="variant"
                                        class="rounded border appearance-none border-gray-300 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 text-base pl-3 pr-10">
                                    @foreach($product_variants as $variant)
                                        <option value="{{ $variant->product_variant_code }}" >{{ $variant->product_variant_name }}</option>
                                    @endforeach
                                </select>
                                <span
                                    class="absolute right-0 top-0 h-full w-10 text-center text-gray-600 pointer-events-none flex items-center justify-center">
                                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                         class="w-4 h-4" viewBox="0 0 24 24">
                                      <path d="M6 9l6 6 6-6"></path>
                                    </svg>
                              </span>
                            </div>

                        </div>

                    </div>
                    <p class="text-blue-500">Change the variant to get the configurations</p>
                    @endif
                    <div>
                        @if($product_variants->count() > 0)
                        <h3 class="text-2xl my-5">Selected variant has the following configurations:</h3>
                        @else
                            <h3 class="text-2xl my-5">The product has following variant configurations:</h3>
                        @endif
                        <div  id="configurations"> </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>

        async function fetchConfigurations() {
            const variantSelectElement = document.getElementById('variant');
            if (!variantSelectElement) {
                const response = await  fetch(`/product/{{ $product->product_code }}`);
                if(response.status === 200) {
                    let configurations = JSON.parse(await response.text()).data ;

                    const parentDiv = document.getElementById('configurations');

                    while (parentDiv.firstChild) {
                        parentDiv.removeChild(parentDiv.lastChild);
                    }

                    configurations.forEach((configuration) => {
                        const divElement = document.createElement('p');
                        divElement.classList.add('flex')
                        divElement.classList.add( 'justify-between' )
                        divElement.classList.add('items-center')
                        const variantName = document.createElement('p');
                        variantName.classList.add('text-xl')
                        variantName.innerText = configuration.code

                        const variantConfig = document.createElement('p');
                        variantConfig.classList.add('text-xl')
                        variantConfig.innerText = `${configuration.value? configuration.value: '1'} ${configuration.name}`

                        divElement.appendChild(variantName)
                        divElement.appendChild(variantConfig)

                        parentDiv.appendChild(divElement)
                    })
                }
            }

            const variantCode = variantSelectElement.value
            const response = await  fetch(`/variant/${variantCode}`);

            if(response.status === 200) {
                let configurations = JSON.parse(await response.text()).data ;
                const parentDiv = document.getElementById('configurations');

                while (parentDiv.firstChild) {
                    parentDiv.removeChild(parentDiv.lastChild);
                }

                configurations.forEach((configuration) => {
                    const divElement = document.createElement('p');
                    divElement.classList.add('flex')
                    divElement.classList.add( 'justify-between' )
                    divElement.classList.add('items-center')
                    const variantName = document.createElement('p');
                    variantName.classList.add('text-xl')
                    variantName.innerText = configuration.code

                    const variantConfig = document.createElement('p');
                    variantConfig.classList.add('text-xl')
                    variantConfig.innerText = `${configuration.value? configuration.value: '1'} ${configuration.name}`

                    divElement.appendChild(variantName)
                    divElement.appendChild(variantConfig)

                    parentDiv.appendChild(divElement)
                })
            }
            // fetch(`/variant/${variantCode}`)
            //     .then(response => {
            //         console.log(response.text())
            //     })
            //     .catch(error => {
            //         console.log(error)
            //     })
        }

        window.addEventListener('load', fetchConfigurations)
    </script>
@endsection
