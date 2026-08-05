<li {{ $attributes->merge(['class' => 'cursor-pointer px-5 py-2 text-base text-foreground transition-colors hover:bg-secondary hover:text-primary max-sm:text-sm']) }}>
    {{ $slot }}
</li>