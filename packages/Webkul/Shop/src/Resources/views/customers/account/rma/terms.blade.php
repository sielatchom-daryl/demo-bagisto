{!! view_render_event('marketplace.seller.account.sign_up.form.agreement.before') !!}

<v-customer-rma-return-policy></v-customer-rma-return-policy>

{!! view_render_event('marketplace.seller.account.sign_up.form.agreement.after') !!}

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-customer-rma-return-policy-template"
    >
        <div class="mb-4">
            <v-field
                type="checkbox" 
                name="agreement" 
                rules="required" 
                v-slot="{ field, errors }" 
                value="1"
            >
                <label class="relative inline-flex items-start gap-2 cursor-pointer">
                    <input
                        type="checkbox"
                        class="sr-only peer"
                        id="agreement"
                        name="agreement"
                        value="1"
                        v-bind="field"
                    />

                    <span
                        class="text-2xl leading-tight cursor-pointer icon-uncheck peer-checked:icon-check-box peer-checked:text-navyBlue"
                    >
                    </span>

                    <span class="block">
                        <span class="text-zinc-500 max-md:text-xs">
                            @lang('shop::app.customers.account.rma.terms.terms')
                        </span>
                        
                        <a 
                            href="javascript:void(0);" 
                            class="ml-1 text-blue-500 hover:text-blue-600 hover:underline max-md:text-xs"
                            @click.prevent="$refs.agreementModel.open()"
                        >
                            @lang('shop::app.customers.account.rma.terms.read')
                        </a>
                    </span>
                </label>

                <span 
                    v-if="errors[0]" 
                    class="block mt-1 text-xs italic text-red-600"
                    v-text="errors[0]"
                >
                </span>
            </v-field>
        </div>

        <!-- Agreement modal -->
        <x-shop::modal ref="agreementModel">
            <!-- Modal Header -->
            <x-slot:header>
                <h2 class="text-lg font-semibold max-md:text-base">
                    @lang('installer::app.seeders.cms.pages.terms-conditions.title')
                </h2>
            </x-slot>

            <!-- Modal Content -->
            <x-slot:content>
                <div 
                    class="p-4 overflow-y-auto border rounded border-border bg-surface" 
                    style="min-height: 400px; max-height: 500px;"
                >
                    <div class="prose-sm prose text-muted max-w-none">
                        {{ core()->getConfigData('sales.rma.setting.return_policy') }}
                    </div>
                </div>
            </x-slot>
        </x-shop::modal>
    </script>

    <script type="module">
        app.component('v-customer-rma-return-policy', {
            template: '#v-customer-rma-return-policy-template',
        })
    </script>
@endPushOnce