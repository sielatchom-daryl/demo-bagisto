{!! view_render_event('bagisto.shop.components.layouts.header.desktop.top.before') !!}

<v-topbar>
    <!-- Shimmer Effect -->
    <div class="flex items-center justify-between px-16 border-b bg-surface border-border">
        <!-- Currencies -->
        <div class="flex w-20 items-center justify-between gap-2.5 py-3">
            <div
                class="w-12 h-6 rounded shimmer"
                role="presentation"
            >
            </div>

            <div
                class="w-6 h-6 rounded shimmer"
                role="presentation"
            >
            </div>
        </div>

        <!-- Offers -->
        <div
            class="h-6 py-3 rounded shimmer w-72"
            role="presentation"
        >
        </div>

        <!-- Locales -->
        <div class="flex w-32 items-center justify-between gap-2.5 py-3">
            <div
                class="w-6 h-6 shimmer"
                role="presentation"
            >
            </div>

            <div
                class="h-6 rounded shimmer w-14"
                role="presentation"
            >
            </div>

            <div
                class="w-6 h-6 shimmer"
                role="presentation"
            >
            </div>
        </div>
    </div>
</v-topbar>

{!! view_render_event('bagisto.shop.components.layouts.header.desktop.top.after') !!}

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-topbar-template"
    >
        <div class="flex items-center justify-between w-full px-16 border-b bg-surface border-border text-foreground">
            {!! view_render_event('bagisto.shop.components.layouts.header.desktop.top.currency_switcher.before') !!}

            <!-- Currency Switcher -->
            <x-shop::dropdown position="bottom-{{ core()->getCurrentLocale()->direction === 'ltr' ? 'left' : 'right' }}">
                <!-- Dropdown Toggler -->
                <x-slot:toggle>
                    <div
                        class="flex cursor-pointer gap-2.5 py-3 text-foreground hover:text-primary transition-colors"
                        role="button"
                        tabindex="0"
                        @click="currencyToggler = ! currencyToggler"
                    >
                        <span v-pre>
                            {{ core()->getCurrentCurrency()->symbol . ' ' . core()->getCurrentCurrencyCode() }}
                        </span>

                        <span
                            class="text-2xl"
                            :class="{'icon-arrow-up': currencyToggler, 'icon-arrow-down': ! currencyToggler}"
                            role="presentation"
                        >
                        </span>
                    </div>
                </x-slot>

                <!-- Dropdown Content -->
                <x-slot:content class="journal-scroll max-h-[500px] !p-0 bg-surface border border-border rounded-lg">
                    <v-currency-switcher></v-currency-switcher>
                </x-slot>
            </x-shop::dropdown>

            {!! view_render_event('bagisto.shop.components.layouts.header.desktop.top.currency_switcher.after') !!}

            <p
                class="py-3 text-xs font-medium text-muted"
                v-pre
            >
                {{ core()->getConfigData('general.content.header_offer.title') }}
                
                <a 
                    href="{{ core()->getConfigData('general.content.header_offer.redirection_link') }}" 
                    class="underline transition-colors text-primary hover:text-accent"
                    role="button"
                >
                    {{ core()->getConfigData('general.content.header_offer.redirection_title') }}
                </a>
            </p>

            {!! view_render_event('bagisto.shop.components.layouts.header.desktop.top.locale_switcher.before') !!}

            <!-- Locales Switcher -->
            <x-shop::dropdown position="bottom-{{ core()->getCurrentLocale()->direction === 'ltr' ? 'right' : 'left' }}">
                <x-slot:toggle>
                    <!-- Dropdown Toggler -->
                    <div
                        class="flex cursor-pointer items-center gap-2.5 py-3 text-foreground hover:text-primary transition-colors"
                        role="button"
                        tabindex="0"
                        @click="localeToggler = ! localeToggler"
                    >
                        <img
                            src="{{ ! empty(core()->getCurrentLocale()->logo_url)
                                    ? core()->getCurrentLocale()->logo_url
                                    : bagisto_asset('images/default-language.svg')
                                }}"
                            class="h-full"
                            alt="@lang('shop::app.components.layouts.header.desktop.top.default-locale')"
                            width="24"
                            height="16"
                        />
                        
                        <span v-pre>
                            {{ core()->getCurrentChannel()->locales()->orderBy('name')->where('code', app()->getLocale())->value('name') }}
                        </span>

                        <span
                            class="text-2xl"
                            :class="{'icon-arrow-up': localeToggler, 'icon-arrow-down': ! localeToggler}"
                            role="presentation"
                        ></span>
                    </div>
                </x-slot>
            
                <!-- Dropdown Content -->
                <x-slot:content class="journal-scroll max-h-[500px] !p-0 bg-surface border border-border rounded-lg">
                    <v-locale-switcher></v-locale-switcher>
                </x-slot>
            </x-shop::dropdown>

            {!! view_render_event('bagisto.shop.components.layouts.header.desktop.top.locale_switcher.after') !!}
        </div>
    </script>

    <script
        type="text/x-template"
        id="v-currency-switcher-template"
    >
        <div class="my-2.5 grid gap-1 overflow-auto max-md:my-0 sm:max-h-[500px]">
            <span
                class="px-5 py-2 text-base transition-colors cursor-pointer text-foreground hover:bg-surface hover:text-primary"
                v-for="currency in currencies"
                :class="{
                    'bg-primary text-secondary font-semibold': currency.code == '{{ core()->getCurrentCurrencyCode() }}'
                }"
                @click="change(currency)"
            >
                @{{ currency.symbol + ' ' + currency.code }}
            </span>
        </div>
    </script>

    <script
        type="text/x-template"
        id="v-locale-switcher-template"
    >
        <div class="my-2.5 grid gap-1 overflow-auto max-md:my-0 sm:max-h-[500px]">
            <span
                class="flex cursor-pointer items-center gap-2.5 px-5 py-2 text-base text-foreground hover:bg-surface hover:text-primary transition-colors"
                :class="{
                    'bg-primary text-secondary font-semibold': locale.code == '{{ app()->getLocale() }}'
                }"
                v-for="locale in locales"
                @click="change(locale)"                  
            >
                <img
                    :src="locale.logo_url || '{{ bagisto_asset('images/default-language.svg') }}'"
                    width="24"
                    height="16"
                />

                @{{ locale.name }}
            </span>
        </div>
    </script>

    <script type="module">
        app.component('v-topbar', {
            template: '#v-topbar-template',

            data() {
                return {
                    localeToggler: '',

                    currencyToggler: '',
                };
            },
        });

        app.component('v-currency-switcher', {
            template: '#v-currency-switcher-template',

            data() {
                return {
                    currencies: @json(core()->getCurrentChannel()->currencies),
                };
            },

            methods: {
                change(currency) {
                    let url = new URL(window.location.href);

                    url.searchParams.set('currency', currency.code);

                    window.location.href = url.href;
                }
            }
        });

        app.component('v-locale-switcher', {
            template: '#v-locale-switcher-template',

            data() {
                return {
                    locales: @json(core()->getCurrentChannel()->locales()->orderBy('name')->get()),
                };
            },

            methods: {
                change(locale) {
                    let url = new URL(window.location.href);

                    url.searchParams.set('locale', locale.code);

                    window.location.href = url.href;
                }
            }
        });
    </script>
@endPushOnce