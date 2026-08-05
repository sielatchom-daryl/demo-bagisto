<x-shop::layouts.account>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.customers.account.orders.title')
    </x-slot>

    <!-- Breadcrumbs -->
    @if ((core()->getConfigData('general.general.breadcrumbs.shop')))
        @section('breadcrumbs')
            <x-shop::breadcrumbs name="orders" />
        @endSection
    @endif

    <div class="mx-4">
        <x-shop::layouts.account.navigation />
    </div>

    <span class="w-full mt-2 mb-5 border-t border-muted"></span>

    <!--Customers logout-->
    @auth('customer')
        <div class="mx-4">
            <div class="mx-auto w-[400px] rounded-lg border border-primary py-2.5 text-center max-sm:w-full max-sm:py-1.5">
                <x-shop::form
                    method="DELETE"
                    action="{{ route('shop.customer.session.destroy') }}"
                    id="customerLogout"
                />

                <a
                    class="flex items-center justify-center gap-1.5 text-base hover:bg-surface"
                    href="{{ route('shop.customer.session.destroy') }}"
                    onclick="event.preventDefault(); document.getElementById('customerLogout').submit();"
                >
                    @lang('shop::app.components.layouts.header.desktop.bottom.logout')
                </a>
            </div>
        </div>
    @endauth

</x-shop::layouts.accounts>