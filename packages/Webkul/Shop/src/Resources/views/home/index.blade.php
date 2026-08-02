@php
    $channel = core()->getCurrentChannel();
@endphp

<!-- SEO Meta Content -->
@push ('meta')
    <meta
        name="title"
        content="{{ $channel->home_seo['meta_title'] ?? '' }}"
    />

    <meta
        name="description"
        content="{{ $channel->home_seo['meta_description'] ?? '' }}"
    />

    <meta
        name="keywords"
        content="{{ $channel->home_seo['meta_keywords'] ?? '' }}"
    />
@endPush

@push('scripts')
    @if(! empty($categories))
        <script>
            localStorage.setItem('categories', JSON.stringify(@json($categories)));
        </script>
    @endif
@endpush

<x-shop::layouts>
    <!-- Page Title -->
    <x-slot:title>
        {{  $channel->home_seo['meta_title'] ?? '' }}
    </x-slot>

    <!-- Hero Section -->
    <section class="bg-[#F1EADF] px-[60px] py-30 max-md:px-5">
        <div class="mx-auto flex max-w-[1200px] items-center justify-between gap-10 max-md:flex-col mt-6">

            <!-- Text Content -->
            <div class="max-w-xl">
                <h1 class="text-5xl font-bold leading-tight text-zinc-800 max-md:text-3xl">
                    @lang('shop::app.home.hero.title')
                </h1>

                <p class="mt-5 text-lg text-zinc-600">
                    @lang('shop::app.home.hero.description')
                </p>

                <div class="flex gap-4 mt-8 mb-8">
                    <a
                        href="{{ route('shop.search.index') }}"
                        class="px-8 py-3 text-white transition bg-black rounded-lg hover:opacity-80"
                    >
                        @lang('shop::app.home.hero.shop_now')
                    </a>

                    <a
                        href="#categories"
                        class="px-8 py-3 text-black border border-black rounded-lg"
                    >
                        @lang('shop::app.home.hero.discover_more')
                    </a>
                </div>
            </div>


            <!-- Hero Image -->
            <div class="max-w-lg">
                <img
                    src="{{ asset('themes/shop/default/assets/images/hero.jpg') }}"
                    alt="Lady Nouby Collection"
                    class="object-cover rounded-xl"
                >
            </div>

        </div>
    </section>

    <!-- Loop over the theme customization -->
    @foreach ($customizations as $customization)
        @php ($data = $customization->options) @endphp

        <!-- Static Content -->
        @switch ($customization->type)
            @case ($customization::IMAGE_CAROUSEL)
                <!-- Image Carousel -->
                <x-shop::carousel
                    :options="$data"
                    aria-label="{{ trans('shop::app.home.index.image-carousel') }}"
                />

                @break
            @case ($customization::STATIC_CONTENT)
                <!-- Push Style -->
                @if (! empty($data['css']))
                    @push ('styles')
                        <style>
                            {!! $data['css'] !!}
                        </style>
                    @endpush
                @endif

                <!-- Render HTML -->
                @if (! empty($data['html']))
                    {!! $data['html'] !!}
                @endif

                @break
            @case ($customization::CATEGORY_CAROUSEL)
                <!-- Categories carousel -->
                <x-shop::categories.carousel
                    :title="$data['title'] ?? ''"
                    :src="route('shop.api.categories.index', $data['filters'] ?? [])"
                    :navigation-link="route('shop.home.index')"
                    aria-label="{{ trans('shop::app.home.index.categories-carousel') }}"
                />

                @break
            @case ($customization::PRODUCT_CAROUSEL)
                <!-- Product Carousel -->
                <x-shop::products.carousel
                    :title="$data['title'] ?? ''"
                    :src="route('shop.api.products.index', $data['filters'] ?? [])"
                    :navigation-link="route('shop.search.index', $data['filters'] ?? [])"
                    aria-label="{{ trans('shop::app.home.index.product-carousel') }}"
                />

                @break
        @endswitch
    @endforeach
</x-shop::layouts>
