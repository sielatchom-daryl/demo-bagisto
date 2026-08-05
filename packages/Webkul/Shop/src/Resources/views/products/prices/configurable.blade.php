<p class="text-sm price-label text-zinc-500 max-sm:text-xs max-sm:leading-4">
    @lang('shop::app.products.prices.configurable.as-low-as')
</p>

@if (isset($prices['final']) && $prices['final']['price'] < $prices['regular']['price'])
    <p class="text-lg font-semibold line-through regular-price text-muted max-sm:text-sm max-sm:leading-4">
        {{ $prices['regular']['formatted_price'] }}
    </p>

    <p class="font-semibold final-price max-sm:leading-4">
        {{ $prices['final']['formatted_price'] }}
    </p>
@else
    <p class="text-lg font-semibold line-through regular-price text-muted max-sm:text-sm max-sm:leading-4" style="display: none;"></p>

    <p class="font-semibold final-price max-sm:leading-4">
        {{ $prices['regular']['formatted_price'] }}
    </p>
@endif