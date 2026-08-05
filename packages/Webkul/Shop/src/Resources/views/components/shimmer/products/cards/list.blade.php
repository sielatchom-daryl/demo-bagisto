@props(['count' => 0])

@for ($i = 0; $i < $count; $i++)
<div class="grid grid-cols-1 gap-6">
    <div class="relative grid grid-cols-2 gap-4 max-w-max max-sm:grid-cols-1">
        <div class="shimmer relative min-h-[258px] min-w-[250px] overflow-hidden rounded"> 
            <img class="rounded-sm bg-secondary">
        </div>

        <div class="grid content-start gap-4">
            <p class="w-3/4 h-6 shimmer"></p>

            <p class="shimmer h-6 w-[55%]"></p>

            <!-- Needs to implement that in future -->
            <div class="flex hidden gap-4"> 
                <span class="block w-8 h-8 rounded-full shimmer"></span> 

                <span class="block w-8 h-8 rounded-full shimmer"></span> 
            </div>

            <p class="w-full h-6 shimmer"></p>

            <div class="shimmer h-12 w-[168px] rounded-xl"></div>
        </div>
    </div>
</div>
@endfor
