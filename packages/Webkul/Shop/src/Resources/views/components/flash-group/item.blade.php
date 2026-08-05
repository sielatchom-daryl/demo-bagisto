<v-flash-item
    v-for='flash in flashes'
    :key='flash.uid'
    :flash="flash"
    @onRemove="remove($event)"
/>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-flash-item-template"
    >
        <div
            class="flex w-max max-w-[408px] justify-between gap-12 rounded-lg border px-5 py-3 shadow-xl backdrop-blur-sm max-sm:max-w-80 max-sm:items-center max-sm:gap-2 max-sm:p-3"
            :style="typeStyles[flash.type]['container']"
        >
            <p
                class="flex items-center text-sm font-medium break-words"
                :style="typeStyles[flash.type]['message']"
            >
                <span
                    class="icon-toast-done text-2xl ltr:mr-2.5 rtl:ml-2.5"
                    :class="iconClasses[flash.type]"
                    :style="typeStyles[flash.type]['icon']"
                ></span>

                @{{ flash.message }}
            </p>

            <span
                class="transition-opacity cursor-pointer icon-cancel max-h-4 max-w-4 hover:opacity-70"
                :style="typeStyles[flash.type]['icon']"
                @click="remove"
            ></span>
        </div>
    </script>

    <script type="module">
        app.component('v-flash-item', {
            template: '#v-flash-item-template',

            props: ['flash'],

            data() {
                return {
                    iconClasses: {
                        success: 'icon-toast-done',

                        error: 'icon-toast-error',

                        warning: 'icon-toast-exclamation-mark',

                        info: 'icon-toast-info',
                    },

                    typeStyles: {
                        success: {
                            container: `
                                background: #111111;
                                border: 1px solid #C9A227;
                            `,

                            message: 'color: #FFFFFF',

                            icon: 'color: #C9A227'
                        },

                        error: {
                            container: `
                                background: #111111;
                                border: 1px solid #FF1C24;
                            `,

                            message: 'color: #FFFFFF',

                            icon: 'color: #FF1C24'
                        },

                        warning: {
                            container: `
                                background: #111111;
                                border: 1px solid #D4AF37;
                            `,

                            message: 'color: #FFFFFF',

                            icon: 'color: #D4AF37'
                        },

                        info: {
                            container: `
                                background: #111111;
                                border: 1px solid #C9A227;
                            `,

                            message: 'color: #FFFFFF',

                            icon: 'color: #C9A227'
                        },
                    },
                };
            },

            mounted() {
                var self = this;

                setTimeout(function() {
                    self.remove()
                }, 2000)
            },

            methods: {
                remove() {
                    this.$emit('onRemove', this.flash)
                }
            }
        });
    </script>
@endpushOnce