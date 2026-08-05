<v-datagrid-mass-action
    :available="available"
    :applied="applied"
>
    {{ $slot }}
</v-datagrid-mass-action>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-datagrid-mass-action-template"
    >
        <slot
            name="mass-action"
            :available="available"
            :applied="applied"
            :mass-actions="massActions"
            :validate-mass-action="validateMassAction"
            :perform-mass-action="performMassAction"
        >
            <div class="flex items-center w-full gap-x-1">
                <x-shop::dropdown position="bottom-left">
                    <x-slot:toggle>
                        <button
                            type="button"
                            class="inline-flex w-full max-w-max cursor-pointer appearance-none items-center justify-between gap-x-2 rounded-md border border-primary bg-surface px-2.5 py-1.5 text-center leading-6 text-foreground transition-all hover:border-primary focus:border-primary"
                        >
                            <span>
                                @lang('shop::app.components.datagrid.toolbar.mass-actions.select-action')
                            </span>

                            <span class="text-2xl icon-arrow-down"></span>
                        </button>
                    </x-slot>

                    <x-slot:menu class="border-border bg-surface !p-0 shadow-[0_5px_20px_rgba(0,0,0,0.35)]">
                        <template v-for="massAction in available.massActions">
                            <li
                                class="relative overflow-visible group/item"
                                v-if="massAction?.options?.length"
                            >
                                <a
                                    class="whitespace-no-wrap !rounded-0 flex cursor-pointer justify-between gap-1.5 bg-surface px-4 py-2 text-foreground hover:bg-secondary"
                                    href="javascript:void(0);"
                                >
                                    <i
                                        class="text-2xl"
                                        :class="massAction.icon"
                                        v-if="massAction?.icon"
                                    >
                                    </i>

                                    <span>
                                        @{{ massAction.title }}
                                    </span>

                                    <i class="text-2xl icon-arrow-right rtl:icon-arrow-left"></i>
                                </a>

                                <ul class="absolute top-0 z-10 hidden w-max min-w-[150px] rounded border border-border bg-surface shadow-[0_5px_20px_rgba(0,0,0,0.35)] group-hover/item:block ltr:left-full rtl:right-full">
                                    <li v-for="option in massAction.options">
                                        <a
                                            class="block px-4 py-2 whitespace-no-wrap rounded-t text-foreground hover:bg-secondary"
                                            href="javascript:void(0);"
                                            @click="performMassAction(massAction, option)"
                                        >
                                            @{{ option.label }}
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li v-else>
                                <a
                                    class="whitespace-no-wrap flex gap-1.5 rounded-b px-4 py-2 text-foreground hover:bg-secondary"
                                    href="javascript:void(0);"
                                    @click="performMassAction(massAction)"
                                >
                                    <i
                                        class="text-2xl"
                                        :class="massAction.icon"
                                        v-if="massAction?.icon"
                                    >
                                    </i>

                                    @{{ massAction.title }}
                                </a>
                            </li>
                        </template>
                    </x-slot>
                </x-shop::dropdown>

                <div class="ltr:pl-2.5 rtl:pr-2.5">
                    <p class="text-sm font-light text-muted">
                        @{{ "@lang('shop::app.components.datagrid.toolbar.length-of')".replace(':length', massActions.indices.length) }}

                        @{{ "@lang('shop::app.components.datagrid.toolbar.selected')".replace(':total', available.meta.total) }}
                    </p>
                </div>
            </div>
        </slot>
    </script>


    <script type="module">
        app.component('v-datagrid-mass-action', {
            template: '#v-datagrid-mass-action-template',

            props: ['available', 'applied'],

            data() {
                return {
                    massActions: {
                        meta: {
                            mode: 'none',

                            action: null,
                        },

                        indices: [],

                        value: null,
                    },
                };
            },

            mounted() {
                this.massActions = this.applied.massActions;
            },

            methods: {
                /**
                 * Validate mass action.
                 *
                 * @param {object} filters
                 * @returns {void}
                 */
                validateMassAction() {
                    if (! this.massActions.indices.length) {
                        this.$emitter.emit('add-flash', { type: 'warning', message: "@lang('shop::app.components.datagrid.toolbar.mass-actions.no-records-selected')" });

                        return false;
                    }

                    if (! this.massActions.meta.action) {
                        this.$emitter.emit('add-flash', { type: 'warning', message: "@lang('shop::app.components.datagrid.toolbar.mass-actions.must-select-a-mass-action')" });

                        return false;
                    }

                    if (
                        this.massActions.meta.action?.options?.length &&
                        this.massActions.value === null
                    ) {
                        this.$emitter.emit('add-flash', { type: 'warning', message: "@lang('shop::app.components.datagrid.toolbar.mass-actions.must-select-a-mass-action-option')" });

                        return false;
                    }

                    return true;
                },

                /**
                 * Perform mass action.
                 *
                 * @param {object} currentAction
                 * @param {object} currentOption
                 * @returns {void}
                 */
                performMassAction(currentAction, currentOption = null) {
                    this.massActions.meta.action = currentAction;

                    if (currentOption) {
                        this.massActions.value = currentOption.value;
                    }

                    if (! this.validateMassAction()) {
                        return;
                    }

                    const { action } = this.massActions.meta;

                    const method = action.method.toLowerCase();

                    this.$emitter.emit('open-confirm-modal', {
                        agree: () => {
                            switch (method) {
                                case 'post':
                                case 'put':
                                case 'patch':
                                    this.$axios[method](action.url, {
                                            indices: this.massActions.indices,
                                            value: this.massActions.value,
                                        })
                                        .then((response) => {
                                            this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });

                                            this.$parent.get();
                                        })
                                        .catch((error) => {
                                            this.$emitter.emit('add-flash', { type: 'error', message: error.response.data.message });

                                            this.$parent.get();
                                        });

                                    break;

                                case 'delete':
                                    this.$axios[method](action.url, {
                                            indices: this.massActions.indices
                                        })
                                        .then(response => {
                                            this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });

                                            /**
                                             * Need to check reason why this.$emit('massActionSuccess') not emitting.
                                             */
                                            this.$parent.get();
                                        })
                                        .catch((error) => {
                                            this.$emitter.emit('add-flash', { type: 'error', message: error.response.data.message });

                                            /**
                                             * Need to check reason why this.$emit('massActionSuccess') not emitting.
                                             */
                                            this.$parent.get();
                                        });

                                    break;

                                default:
                                    console.error('Method not supported.');

                                    break;
                            }

                            this.massActions.indices  = [];
                        },
                    });
                },
            },
        });
    </script>
@endPushOnce
