@props(['count' => 0])

@for ($i = 0;  $i < $count; $i++)
    <div class="p-6 border rounded-xl border-border">
        <div class="flex gap-5">
            <div class="shimmer h-[100px] w-[100px] rounded-xl"></div>

            <div class="flex flex-col gap-0.5">
                <p class="w-40 shimmer h-7"></p
>
                <p class="w-40 h-4 mb-2 shimmer"></p>

                <div class="flex items-center gap-0.5">
                    <span class="shimmer h-[30px] w-[30px]"></span>
                    <span class="shimmer h-[30px] w-[30px]"></span>
                    <span class="shimmer h-[30px] w-[30px]"></span>
                    <span class="shimmer h-[30px] w-[30px]"></span>
                    <span class="shimmer h-[30px] w-[30px]"></span>
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-4 mt-3">
            <div class="shimmer h-6 w-[250px]"></div>

            <div class="flex flex-col gap-0.5">
                <p class="shimmer h-6 w-[500px]"></p>
                <p class="shimmer h-6 w-[300px]"></p>
            </div>
        </div>
    </div>
@endfor