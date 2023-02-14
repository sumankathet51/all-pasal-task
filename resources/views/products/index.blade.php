@extends('layouts.app')
@section('content')

    <section class="text-gray-600 body-font overflow-hidden">
        <div class="container px-5 py-5 mx-auto">
            <h1 class="text-3xl font-bold py-5">All products</h1>
            @foreach($products as $product)

            <div class="-my-8 divide-y-2 divide-gray-100">
                <div class="py-8 flex flex-wrap md:flex-nowrap gap-3">
                    <div class="md:w-64 md:mb-0 mb-6 flex-shrink-0 flex items-center justify-center flex-col bg-gray-100">
                        <p>Product Image</p>
                    </div>
                    <div class="md:flex-grow">
                        <h2 class="text-2xl font-medium text-gray-900 title-font mb-2">{{ $product->product_name }}</h2>
                        {!! \Illuminate\Support\Str::limit($product->description, 200, '...')  !!}
                            <a class="text-indigo-500 inline-flex items-center mt-4 cursor-pointer hover:text-indigo-700" href="{{ route('products.show', $product->slug) }}">Learn More
                            <svg class="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14"></path>
                                <path d="M12 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>

            </div>
            @endforeach

        </div>
    </section>


    {{ $products->links('pagination::tailwind') }}
@endsection
