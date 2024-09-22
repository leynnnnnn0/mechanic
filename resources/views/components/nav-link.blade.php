@props(['active' => false])
<a {{ $attributes}} class="cursor-pointer text-sm font-bold hover:text-blue-400 transtion transition-colors duration-300 {{ $active ? 'border-b-2 border-blue-500' : 'text-black'}}" wire:navigate>
    {{ $slot }}
</a>