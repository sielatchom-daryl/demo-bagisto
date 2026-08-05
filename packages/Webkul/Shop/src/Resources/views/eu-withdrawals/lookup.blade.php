<x-shop::layouts>
    <x-slot:title>
        @lang('shop::app.eu_withdrawal.lookup.page_title')
    </x-slot>

    <div class="container max-w-xl px-5 mx-auto mt-10 max-md:mt-6 max-md:px-4">
        <div class="p-8 border bg-background rounded-xl border-border max-sm:p-5">
            <h1 class="text-2xl font-medium max-md:text-xl">
                @lang('shop::app.eu_withdrawal.lookup.heading')
            </h1>

            <p class="mt-2 text-sm text-muted">
                @lang('shop::app.eu_withdrawal.lookup.intro')
            </p>

            @if (session('lookup_sent'))
                <div class="flex items-start gap-3 p-4 mt-6 text-sm border rounded-xl border-emerald-200 bg-emerald-50 text-emerald-800">
                    <span class="icon-check-box mt-0.5 text-xl leading-none"></span>

                    <p>@lang('shop::app.eu_withdrawal.lookup.sent_notice')</p>
                </div>
            @endif

            <form
                method="POST"
                action="{{ route('shop.eu-withdrawal.guest.lookup.submit') }}"
                class="mt-6 space-y-5"
            >
                @csrf

                <div>
                    <label
                        for="order_increment_id"
                        class="mb-1.5 block text-sm font-medium text-foreground"
                    >
                        @lang('shop::app.eu_withdrawal.lookup.order_number')
                    </label>

                    <input
                        id="order_increment_id"
                        name="order_increment_id"
                        type="text"
                        required
                        autocomplete="off"
                        value="{{ old('order_increment_id') }}"
                        class="block w-full px-4 py-3 text-sm border rounded-lg border-border focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                    >

                    @error('order_increment_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label
                        for="email"
                        class="mb-1.5 block text-sm font-medium text-foreground"
                    >
                        @lang('shop::app.eu_withdrawal.lookup.email')
                    </label>

                    <input
                        id="email"
                        name="email"
                        type="email"
                        required
                        autocomplete="email"
                        value="{{ old('email') }}"
                        class="block w-full px-4 py-3 text-sm border rounded-lg border-border focus:border-primary focus:outline-none focus:ring-1 focus:ring-navyBlue"
                    >
                    
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button
                    type="submit"
                    class="w-full py-3 text-base primary-button"
                >
                    @lang('shop::app.eu_withdrawal.lookup.submit')
                </button>
            </form>
        </div>

        <p class="mt-6 text-xs text-center text-muted">
            @lang('shop::app.eu_withdrawal.lookup.legal_note')
        </p>
    </div>
</x-shop::layouts>
