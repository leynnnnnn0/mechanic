@props(['active' => false])
<a {{ $attributes}} class="cursor-pointer text-2xl font-bold hover:text-blue-400 transtion transition-colors duration-300 {{ $active ? 'text-blue-500' : 'text-white'}}" wire:navigate>
    {{ $slot }}
</a>