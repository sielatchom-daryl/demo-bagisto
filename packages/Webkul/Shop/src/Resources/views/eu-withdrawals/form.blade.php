<x-shop::layouts>
    <x-slot:title>
        @lang('shop::app.eu_withdrawal.form.page_title')
    </x-slot>

    <div class="container max-w-3xl px-5 mx-auto mt-10 max-md:mt-6 max-md:px-4">
        <h1 class="text-2xl font-medium max-md:text-xl">
            @lang('shop::app.eu_withdrawal.form.heading')
        </h1>

        {{-- Statutory Effect Notice --}}
        <div class="flex items-start gap-3 p-4 mt-4 text-sm border rounded-xl border-accent/60 bg-accent text-primary">
            <span class="icon-warning mt-0.5 text-xl leading-none"></span>

            <div>
                <p class="font-medium">
                    @lang('shop::app.eu_withdrawal.form.legal_notice_title')
                </p>

                <p class="mt-1 text-primary">
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

            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                {{-- Order Summary --}}
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

                        <div class="flex items-center justify-between text-muted">
                            <span>@lang('shop::app.eu_withdrawal.form.order_items')</span>

                            <span class="font-medium text-primary">{{ $order->total_qty_ordered }}</span>
                        </div>
                    </div>
                </aside>

                {{-- Reason Input --}}
                <div class="p-5 border bg-background rounded-xl border-border md:col-span-2">
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
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Action Footer — Spans the full form width, not tucked inside the reason card. --}}
            <div class="flex items-center justify-end gap-3 mt-6">
                <a
                    href="{{ route('shop.home.index') }}"
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
        </form>
    </div>
</x-shop::layouts>
