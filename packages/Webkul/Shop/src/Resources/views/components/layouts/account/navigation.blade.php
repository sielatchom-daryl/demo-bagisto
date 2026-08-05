@php
    $customer = auth()->guard('customer')->user();
@endphp

<div class="panel-side journal-scroll grid max-h-[1320px] min-w-[342px] max-w-[380px] grid-cols-[1fr] gap-8 overflow-y-auto overflow-x-hidden text-foreground max-xl:min-w-[270px] max-md:max-w-full max-md:gap-5">
    <!-- Account Profile Hero Section -->
    <div class="grid grid-cols-[auto_1fr] items-center gap-4 rounded-xl border border-border bg-surface px-5 py-[25px] shadow-lg max-md:py-2.5">
        <div class="">
            <img
                src="{{ $customer->image_url ??  bagisto_asset('images/user-placeholder.png') }}"
                class="h-[60px] w-[60px] rounded-full border-2 border-primary object-cover"
                alt="Profile Image"
            >
        </div>

        <div 
            class="flex flex-col justify-between"
            v-pre
        >
            <p class="text-2xl font-semibold break-all text-foreground max-md:text-xl"> 
                Hello! {{ $customer->first_name }}
            </p>

            <p class="text-sm break-all text-muted">
                {{ $customer->email }}
            </p>
        </div>
    </div>

    <!-- Account Navigation Menus -->
    @foreach (menu()->getItems('customer') as $menuItem)
        <div>
            <!-- Account Navigation Toggler -->
            <div class="select-none pb-5 max-md:pb-1.5">
                <p class="text-xl font-semibold tracking-wide uppercase text-primary max-md:text-lg"">
                    {{ $menuItem->getName() }}
                </p>
            </div>

            <!-- Account Navigation Content -->
            @if ($menuItem->haveChildren())
                <div class="grid overflow-hidden border rounded-xl border-border bg-surface max-md:border-none">
                    @foreach ($menuItem->getChildren() as $subMenuItem)
                        <a href="{{ $subMenuItem->getUrl() }}">
                            <div class="flex justify-between px-6 py-5 border-t border-border transition-all duration-200 hover:bg-primary hover:text-secondary cursor-pointer max-md:p-4 max-md:border-0 max-md:py-3 max-md:px-0 {{ $subMenuItem->isActive() ? 'bg-primary text-secondary' : 'text-foreground' }}">
                                <p class="flex items-center text-lg font-medium gap-x-4 max-sm:text-base">
                                    <span class="{{ $subMenuItem->getIcon() }} text-2xl"></span>

                                    {{ $subMenuItem->getName() }}
                                </p>

                                <span class="text-xl icon-arrow-right rtl:icon-arrow-left"></span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    @endforeach
</div>