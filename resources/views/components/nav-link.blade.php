<a {{ $attributes->merge(['class' => 'text-sm font-bold'])}} wire:navigate>
    {{ $slot }}
</a>