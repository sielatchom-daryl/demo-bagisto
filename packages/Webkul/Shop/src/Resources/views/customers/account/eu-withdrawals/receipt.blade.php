{{--
    Shared withdrawal receipt presentation.
    Used by both the auth-customer confirmation page and the guest signed-URL page.
    $withdrawal (Withdrawal model), $isGuest (bool).
--}}
@php
    $isDeclined = $withdrawal->status === 'declined';

    $statusContext = [
        'received' => [
            'badge'   => 'bg-primary/20 text-primary',
            'hero_bg' => 'bg-primary/20 text-primary',
        ],

        'refunded' => [
            'badge'   => 'bg-primary text-secondary',
            'hero_bg' => 'bg-primary text-secondary',
        ],

        'declined' => [
            'badge'   => 'bg-red-900/20 text-red-400',
            'hero_bg' => 'bg-red-900/20 text-red-400',
        ],
    ][$withdrawal->status] ?? [
        'badge'   => 'bg-surface text-foreground',
        'hero_bg' => 'bg-surface text-foreground',
    ];
@endphp

<style>
    @media print {
        @page {
            margin: 12mm;
        }

        html,
        body {
            background: #ffffff !important;
        }

        body * {
            visibility: hidden !important;
        }

        #eu-withdrawal-print-area,
        #eu-withdrawal-print-area * {
            visibility: visible !important;
        }

        #eu-withdrawal-print-area {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
            background: #ffffff !important;
            color: #000000 !important;
            z-index: 2147483647 !important;
        }

        #eu-withdrawal-print-area .print\:hidden,
        #eu-withdrawal-print-area [data-eu-clipboard] {
            display: none !important;
        }
    }
</style>

<div id="eu-withdrawal-print-area">
    <div class="flex items-center justify-between max-sm:flex-col max-sm:items-start max-sm:gap-3">
        <div class="flex items-center gap-3">
            <span class="grid h-10 w-10 flex-shrink-0 place-items-center rounded-full {{ $statusContext['hero_bg'] }}">
                @if ($isDeclined)
                    <span class="text-2xl font-bold leading-none">&times;</span>
                @else
                    <span class="text-2xl icon-check-box"></span>
                @endif
            </span>

            <div>
                <h2 class="text-2xl font-medium text-foreground max-md:text-xl max-sm:text-base">
                    @lang('shop::app.eu_withdrawal.confirmation.heading_'.$withdrawal->status)
                </h2>

                <p class="text-sm text-muted max-sm:hidden">
                    @lang('shop::app.eu_withdrawal.confirmation.intro_'.$withdrawal->status)
                </p>
            </div>
        </div>

        <button
            type="button"
            data-eu-print
            data-eu-print-title="@lang('shop::app.eu_withdrawal.confirmation.page_title')"
            class="secondary-button px-4 py-2 text-sm font-normal transition-all duration-300 hover:scale-[1.02] max-md:rounded-lg print:hidden"
        >
            @lang('shop::app.eu_withdrawal.confirmation.print')
        </button>
    </div>

    <p class="mt-3 text-sm text-muted sm:hidden">
        @lang('shop::app.eu_withdrawal.confirmation.intro_'.$withdrawal->status)
    </p>

    {{-- Receipt Card --}}
    <div class="mt-8 overflow-hidden border rounded-xl border-border bg-surface">
        <dl class="grid grid-cols-1 divide-y divide-border sm:grid-cols-2 sm:divide-x sm:divide-y-0">
            <div class="px-6 py-4">
                <dt class="text-xs font-medium tracking-wide uppercase text-muted">
                    @lang('shop::app.eu_withdrawal.confirmation.received_at')
                </dt>

                <dd class="mt-1 text-sm font-medium text-foreground">
                    {{ $withdrawal->received_at->copy()->setTimezone('UTC')->format('d M Y, H:i') }}
                    <span class="text-muted">UTC</span>
                </dd>
            </div>

            <div class="px-6 py-4">
                <dt class="text-xs font-medium tracking-wide uppercase text-muted">
                    @lang('shop::app.eu_withdrawal.confirmation.reference')
                </dt>

                <dd class="flex items-center gap-2 px-3 py-2 mt-1 border rounded-lg border-border bg-background">
                    <code class="flex-1 font-mono text-sm font-medium break-all text-foreground">
                        {{ $withdrawal->uuid }}
                    </code>

                    <button
                        type="button"
                        title="@lang('shop::app.eu_withdrawal.confirmation.copy_reference')"
                        data-eu-clipboard="{{ $withdrawal->uuid }}"
                        data-eu-clipboard-message="@lang('shop::app.eu_withdrawal.confirmation.reference_copied')"
                        class="grid flex-shrink-0 transition-all rounded-md h-7 w-7 place-items-center text-muted hover:bg-primary/10 hover:text-primary"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                        </svg>
                    </button>
                </dd>
            </div>

            <div class="px-6 py-4 sm:border-t sm:border-border">
                <dt class="text-xs font-medium tracking-wide uppercase text-muted">
                    @lang('shop::app.eu_withdrawal.confirmation.order')
                </dt>

                <dd class="mt-1 text-sm font-medium text-foreground">
                    @if (! $isGuest)
                        <a
                            href="{{ route('shop.customers.account.orders.view', $withdrawal->order_id) }}"
                            class="transition-colors text-primary hover:text-accent hover:underline"
                        >
                            #{{ $withdrawal->order->increment_id ?? $withdrawal->order_id }}
                        </a>
                    @else
                        #{{ $withdrawal->order->increment_id ?? $withdrawal->order_id }}
                    @endif
                </dd>
            </div>

            <div class="px-6 py-4 sm:border-t sm:border-border">
                <dt class="text-xs font-medium tracking-wide uppercase text-muted">
                    @lang('shop::app.eu_withdrawal.confirmation.email')
                </dt>

                <dd class="mt-1 text-sm font-medium text-foreground">
                    {{ $withdrawal->customer_email }}
                </dd>
            </div>

            <div class="px-6 py-4 sm:border-t sm:border-border">
                <dt class="text-xs font-medium tracking-wide uppercase text-muted">
                    @lang('shop::app.eu_withdrawal.confirmation.status')
                </dt>

                <dd class="mt-1">
                    <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium {{ $statusContext['badge'] }}">
                        @lang('shop::app.eu_withdrawal.confirmation.status_'.$withdrawal->status)
                    </span>
                </dd>
            </div>

            <div class="px-6 py-4 sm:border-t sm:border-border">
                <dt class="text-xs font-medium tracking-wide uppercase text-muted">
                    @lang('shop::app.eu_withdrawal.confirmation.reason')
                </dt>

                <dd class="mt-1 text-sm whitespace-pre-wrap text-foreground">
                    {{ $withdrawal->reason_text ?: '—' }}
                </dd>
            </div>
        </dl>
    </div>

    {{-- Refund Timeline --}}
    <div class="p-5 mt-6 border rounded-xl border-border bg-surface">
        <h3 class="text-base font-medium text-foreground">
            @lang('shop::app.eu_withdrawal.confirmation.next_steps_title')
        </h3>

        <ol class="mt-4 space-y-3 text-sm">
            <li class="flex gap-3">
                <span class="grid flex-shrink-0 w-6 h-6 rounded-full place-items-center bg-primary/20 text-primary icon-check-box"></span>

                <div>
                    <p class="font-medium text-foreground">
                        @lang('shop::app.eu_withdrawal.confirmation.step_received')
                    </p>

                    <p class="text-xs text-muted">
                        {{ $withdrawal->received_at->copy()->setTimezone('UTC')->format('d M Y, H:i') }} UTC
                    </p>
                </div>
            </li>

            <li class="flex gap-3">
                @if ($withdrawal->confirmation_sent_at)
                    <span class="grid flex-shrink-0 w-6 h-6 rounded-full place-items-center bg-primary/20 text-primary icon-check-box"></span>
                @else
                    <span class="grid flex-shrink-0 w-6 h-6 border rounded-full place-items-center border-border text-muted icon-radio-unselect"></span>
                @endif

                <div>
                    <p class="font-medium text-foreground">
                        @lang('shop::app.eu_withdrawal.confirmation.step_email')
                    </p>

                    <p class="text-xs text-muted">
                        @if ($withdrawal->confirmation_sent_at)
                            @lang('shop::app.eu_withdrawal.confirmation.email_sent')
                        @elseif ($withdrawal->confirmation_error)
                            <span class="text-amber-400">
                                @lang('shop::app.eu_withdrawal.confirmation.email_pending')
                            </span>
                        @else
                            @lang('shop::app.eu_withdrawal.confirmation.email_pending')
                        @endif
                    </p>
                </div>
            </li>

            <li class="flex gap-3">
                @if ($withdrawal->refunded_at)
                    <span class="grid flex-shrink-0 w-6 h-6 rounded-full place-items-center bg-primary/20 text-primary icon-check-box"></span>

                    <div>
                        <p class="font-medium text-foreground">
                            @lang('shop::app.eu_withdrawal.confirmation.step_refund_done')
                        </p>

                        <p class="text-xs text-muted">
                            {{ $withdrawal->refunded_at->copy()->setTimezone('UTC')->format('d M Y, H:i') }} UTC
                        </p>
                    </div>
                @elseif ($withdrawal->declined_at)
                    <span class="grid flex-shrink-0 w-6 h-6 text-red-400 rounded-full place-items-center bg-red-900/20">
                        <span class="text-base font-bold leading-none">&times;</span>
                    </span>

                    <div class="flex-1">
                        <p class="font-medium text-foreground">
                            @lang('shop::app.eu_withdrawal.confirmation.step_declined')
                        </p>

                        @if ($withdrawal->declined_reason)
                            <div class="p-3 mt-2 border rounded-md border-red-900/30 bg-red-900/10">
                                <p class="text-xs font-medium tracking-wide text-red-400 uppercase">
                                    @lang('shop::app.eu_withdrawal.confirmation.declined_reason_label')
                                </p>

                                <p class="mt-1 text-sm text-red-300 whitespace-pre-wrap">
                                    {{ $withdrawal->declined_reason }}
                                </p>
                            </div>
                        @endif

                        <p class="mt-2 text-xs text-muted">
                            @lang('shop::app.eu_withdrawal.confirmation.declined_notice')
                        </p>
                    </div>
                @else
                    <span class="grid flex-shrink-0 w-6 h-6 border rounded-full place-items-center border-border text-muted icon-radio-unselect"></span>

                    <div>
                        <p class="font-medium text-foreground">
                            @lang('shop::app.eu_withdrawal.confirmation.step_refund')
                        </p>

                        <p class="text-xs text-muted">
                            @lang('shop::app.eu_withdrawal.confirmation.refund_notice')
                        </p>
                    </div>
                @endif
            </li>
        </ol>
    </div>

    <p class="mt-6 text-xs text-muted">
        @lang('shop::app.eu_withdrawal.confirmation.durable_medium_notice')
    </p>
</div>

@if (! $isGuest)
    <div class="mt-6 print:hidden">
        <a
            href="{{ route('shop.customers.account.orders.view', $withdrawal->order_id) }}"
            class="inline-flex items-center gap-1 text-sm transition-colors text-primary hover:text-accent hover:underline"
        >
            <span class="icon-arrow-left rtl:icon-arrow-right"></span>

            @lang('shop::app.customers.account.orders.title')
        </a>
    </div>
@endif

@pushOnce('scripts')
    <script>
        document.addEventListener('click', async function (event) {
            const button = event.target.closest('[data-eu-clipboard]');

            if (! button) {
                return;
            }

            event.preventDefault();

            const text = button.getAttribute('data-eu-clipboard');
            const message = button.getAttribute('data-eu-clipboard-message') || 'Copied';

            try {
                if (navigator.clipboard && window.isSecureContext) {
                    await navigator.clipboard.writeText(text);
                } else {
                    const ta = document.createElement('textarea');
                    ta.value = text;
                    ta.style.position = 'fixed';
                    ta.style.opacity = '0';
                    document.body.appendChild(ta);
                    ta.select();
                    document.execCommand('copy');
                    document.body.removeChild(ta);
                }

                const emitter = window?.app?.config?.globalProperties?.$emitter;

                if (emitter) {
                    emitter.emit('add-flash', { type: 'success', message: message });
                }
            } catch (err) {
                console.error('Copy failed:', err);
            }
        });

        document.addEventListener('click', function (event) {
            const trigger = event.target.closest('[data-eu-print]');

            if (! trigger) {
                return;
            }

            event.preventDefault();

            const printArea = document.getElementById('eu-withdrawal-print-area');

            if (! printArea) {
                window.print();

                return;
            }

            const HIDDEN_CLASS = 'eu-print-temp-hidden';
            const WRAPPER_ID = 'eu-print-temp-wrapper';
            const STYLE_ID = 'eu-print-temp-style';

            const cleanup = function () {
                const wrapper = document.getElementById(WRAPPER_ID);
                const styleEl = document.getElementById(STYLE_ID);

                if (wrapper) wrapper.remove();
                if (styleEl) styleEl.remove();

                document.querySelectorAll('.' + HIDDEN_CLASS).forEach(function (el) {
                    el.classList.remove(HIDDEN_CLASS);
                });

                window.removeEventListener('afterprint', cleanup);
            };

            cleanup();

            const styleEl = document.createElement('style');
            styleEl.id = STYLE_ID;
            styleEl.textContent =
                '.' + HIDDEN_CLASS + '{display:none !important;}'
                + '#' + WRAPPER_ID + '{background:#fff;color:#000;padding:24px;}'
                + '#' + WRAPPER_ID + ' [data-eu-clipboard],'
                + '#' + WRAPPER_ID + ' [data-eu-print]{display:none !important;}'
                + '@media print{@page{margin:12mm;}html,body{background:#fff !important;}}';
            document.head.appendChild(styleEl);

            Array.from(document.body.children).forEach(function (child) {
                child.classList.add(HIDDEN_CLASS);
            });

            const wrapper = document.createElement('div');
            wrapper.id = WRAPPER_ID;
            wrapper.appendChild(printArea.cloneNode(true));
            document.body.appendChild(wrapper);

            window.addEventListener('afterprint', cleanup);

            setTimeout(function () {
                window.print();
            }, 80);
        });
    </script>
@endPushOnce
