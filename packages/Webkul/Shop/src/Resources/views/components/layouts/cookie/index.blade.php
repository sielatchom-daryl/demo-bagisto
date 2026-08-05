{!! view_render_event('bagisto.shop.settings.gdpr.modal.before') !!}

<v-cookie></v-cookie>

{!! view_render_event('bagisto.shop.settings.gdpr.modal.before') !!}

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-cookie-template"
    >
        {!! view_render_event('bagisto.shop.settings.gdpr.modal.cookie.before') !!}

            @if (core()->getConfigData('general.gdpr.cookie.enabled'))
                <div
                    class="js-cookie-consent fixed z-[999] mx-4 hidden min-h-5 overflow-hidden rounded-xl border border-border bg-surface p-7 shadow-2xl"
                    :class="getPositionClasses(position)"
                >
                    <div class="cookieTitle">
                        <span
                            class="block mb-2 text-xl font-semibold leading-6 text-foreground"
                            v-pre
                        >
                            {{ core()->getConfigData('general.gdpr.cookie.static_block_identifier') }}
                        </span>
                    </div>

                    <div class="cookieDesc cookie-consent__message">
                        <p
                            class="mt-3 text-sm leading-6 text-muted"
                            v-pre
                        >
                            {{ core()->getConfigData('general.gdpr.cookie.description') }}

                            <a
                                class="underline text-primary hover:text-accent"
                                href="{{ url('page/privacy-policy') }}"
                            >
                                @lang('shop::app.components.layouts.cookie.index.privacy-policy')
                            </a>
                        </p>
                    </div>

                    <div class="cookieButton">
                        <div class="mt-2.5 flex gap-3">
                            <button
                                class="w-full px-6 py-3 text-sm font-semibold transition rounded-lg bg-primary text-secondary hover:bg-accent"
                                @click="createCookie()"
                            >
                                @lang('shop::app.components.layouts.cookie.index.accept')
                            </button>

                            <button
                                class="w-full px-6 py-3 text-sm font-semibold transition border rounded-lg border-border bg-surface text-foreground hover:border-primary hover:text-primary"
                                @click="rejectCookie()"
                            >
                                @lang('shop::app.components.layouts.cookie.index.reject')
                            </button>
                        </div>

                        <a
                            class="inline-block w-full px-6 py-3 mt-3 text-sm font-semibold text-center transition border rounded-lg border-primary text-primary hover:bg-primary hover:text-secondary"
                            href="{{ route('shop.customers.gdpr.cookie-consent') }}"
                        >
                            @lang('shop::app.components.layouts.cookie.index.learn-more-and-customize')
                        </a>
                    </div>
                </div>
            @endif

        {!! view_render_event('bagisto.shop.settings.gdpr.modal.cookie.before') !!}
    </script>

    <script type="module">
        const secureFlag = {!! json_encode(config('session.secure') ? ';secure' : '') !!};
        const sameSiteFlag = {!! json_encode(config('session.same_site') ? ';samesite=' . config('session.same_site') : '') !!};

        app.component('v-cookie', {
            template: '#v-cookie-template',

            data() {
                return {
                    cookieDomain: '{{ config('session.domain') ?? request()->getHost() }}',
                    cookieIp: "{{ request()->ip() }}",
                    position: "{{ core()->getConfigData('general.gdpr.cookie.position') ?? 'center' }}"
                };
            },

            mounted() {
                if (! this.cookieExists()) {
                    this.showCookieDialog();
                }
            },

            methods: {
                getPositionClasses(position) {
                    const positionClasses = {
                        'center': 'left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 max-w-[420px]',
                        'top-center': 'top-4 left-1/2 -translate-x-1/2 max-w-[420px]',
                        'bottom-center': 'bottom-4 left-1/2 -translate-x-1/2 max-w-[420px]',
                        'bottom-right': 'bottom-4 right-0 sm:max-w-[420px]',
                        'bottom-left': 'bottom-4 left-0 sm:max-w-[420px]',
                        'top-right': 'top-4 right-0 sm:max-w-[420px]',
                        'top-left': 'top-4 left-0 sm:max-w-[420px]',
                    };

                    return positionClasses[position] || positionClasses['center'];
                },

                createCookie() {
                    this.consentWithCookies();

                    this.acceptAllConsentWithCookies();

                    this.hideCookieDialog();
                },

                rejectCookie() {
                    this.hideCookieDialog();
                },

                setCookie(name, value, expirationInDays) {
                    const date = new Date();

                    date.setTime(date.getTime() + (expirationInDays * 24 * 60 * 60 * 1000));

                    document.cookie = `${name}=${value};expires=${date.toUTCString()};path=/${secureFlag}${sameSiteFlag}`;
                },

                consentWithCookies() {
                    this.setCookie('cookie-consent', 1, 365 * 20);
                },

                acceptAllConsentWithCookies() {
                    this.setCookie('ip_address', this.cookieIp, 365 * 20);
                },

                cookieExists() {
                    return document.cookie.includes(`cookie-consent=${1}`);
                },

                hideCookieDialog() {
                    const cookieConsentElement = document.querySelector('.js-cookie-consent');

                    if (cookieConsentElement) {
                        cookieConsentElement.style.display = 'none';
                    }
                },

                showCookieDialog() {
                    const cookieConsentElement = document.querySelector('.js-cookie-consent');

                    if (cookieConsentElement) {
                        cookieConsentElement.style.display = 'block';
                    }
                },
            },
        });
    </script>
@endPushOnce
