<x-shop::layouts.account>
    <x-slot:title>
        @lang('shop::app.eu_withdrawal.form.page_title')
    </x-slot>

    @if ((core()->getConfigData('general.general.breadcrumbs.shop')))
        @section('breadcrumbs')
            <x-shop::breadcrumbs name="account.eu-withdrawal.create" />
        @endSection
    @endif

    <div class="max-md:hidden">
        <x-shop::layouts.account.navigation />
    </div>

    <div class="flex-auto mx-4 max-md:mx-6 max-sm:mx-4">
        <div class="flex items-center">
            <a
                class="grid md:hidden"
                href="{{ route('shop.customers.account.orders.view', $order->id) }}"
            >
                <span class="text-2xl icon-arrow-left rtl:icon-arrow-right"></span>
            </a>

            <h2 class="text-2xl font-medium max-md:text-xl max-sm:text-base ltr:ml-2.5 md:ltr:ml-0 rtl:mr-2.5 md:rtl:mr-0">
                @lang('shop::app.eu_withdrawal.form.heading')
            </h2>
        </div>

        {{-- Statutory effect notice --}}
        <div class="flex items-start gap-3 p-4 mt-6 text-sm border rounded-xl border-accent bg-surface text-foreground">
            <span class="icon-warning mt-0.5 text-xl leading-none"></span>

            <div>
                <p class="font-medium">
                    @lang('shop::app.eu_withdrawal.form.legal_notice_title')
                </p>

                <p class="mt-1 text-foreground">
                    @lang('shop::app.eu_withdrawal.form.legal_effect', [
                        'order_id' => $order->increment_id ?? $order->id,
                    ])
                </p>
            </div>
        </div>

        <form
            method="POST"
            action="{{ $formUrl }}"
            class="mt-6"
        >
            @csrf

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                {{-- Order summary card --}}
                <aside class="p-5 border bg-background rounded-xl border-border">
                    <p class="text-xs font-medium tracking-wide uppercase text-muted">
                        @lang('shop::app.eu_withdrawal.form.order_summary')
                    </p>

                    <p class="mt-2 text-lg font-semibold text-foreground">
                        #{{ $order->increment_id ?? $order->id }}
                    </p>

                    <p class="mt-1 text-sm text-muted">
                        @lang('shop::app.eu_withdrawal.form.placed_on',
                            ['date' => core()->formatDate($order->created_at, 'd M Y')])
                    </p>

                    <div class="grid gap-2 pt-4 mt-4 text-sm border-t border-border">
                        <div class="flex items-center justify-between text-muted">
                            <span>@lang('shop::app.eu_withdrawal.form.order_total')</span>

                            <span class="font-medium text-foreground">{{ core()->formatPrice($order->grand_total, $order->order_currency_code) }}</span>
                        </div>

                        <div class="flex items-center justify-between text-foreground">
                            <span>@lang('shop::app.eu_withdrawal.form.order_items')</span>

                            <span class="font-medium text-foreground">{{ $order->total_qty_ordered }}</span>
                        </div>
                    </div>
                </aside>

                {{-- Reason input --}}
                <div class="p-5 border bg-background rounded-xl border-border lg:col-span-2">
                    <label
                        for="reason_text"
                        class="block text-base font-medium text-foreground"
                    >
                        @lang('shop::app.eu_withdrawal.form.reason_label')
                        
                        <span class="ml-1 text-xs font-normal text-muted">
                            @lang('shop::app.eu_withdrawal.form.reason_optional')
                        </span>
                    </label>

                    <p class="mt-1 text-xs text-muted">
                        @lang('shop::app.eu_withdrawal.form.reason_help')
                    </p>

                    <textarea
                        id="reason_text"
                        name="reason_text"
                        rows="6"
                        maxlength="5000"
                        class="block w-full px-4 py-3 mt-3 text-sm border rounded-lg border-border focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                        placeholder="@lang('shop::app.eu_withdrawal.form.reason_placeholder')"
                    >{{ old('reason_text') }}</textarea>

                    @error('reason_text')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                    @enderror

                    <div class="flex items-center justify-end gap-3 pt-5 mt-6 border-t border-border">
                        <a
                            href="{{ route('shop.customers.account.orders.view', $order->id) }}"
                            class="px-5 py-3 font-normal secondary-button border-border"
                        >
                            @lang('shop::app.eu_withdrawal.form.cancel')
                        </a>

                        <button
                            type="submit"
                            class="px-6 py-3 primary-button"
                        >
                            @lang('shop::app.eu_withdrawal.form.submit')
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-shop::layouts.account>
