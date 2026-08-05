@props(['isMultiRow' => false])

<div>
    <x-shop::shimmer.datagrid.toolbar />

    <div class="flex mt-8 overflow-x-auto border rounded-xl">
        <div class="w-full">
            <div class="grid w-full overflow-hidden rounded table-responsive box-shadow bg-background">
                <x-shop::shimmer.datagrid.table.head :isMultiRow="$isMultiRow" />

                <x-shop::shimmer.datagrid.table.body :isMultiRow="$isMultiRow" />

                <x-shop::shimmer.datagrid.table.footer />
            </div>
        </div>
    </div>
</div>
