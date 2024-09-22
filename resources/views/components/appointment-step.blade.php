@props(['active' => false])
<section class="font-bold flex-1 flex items-center justify-center p-5 {{ $active ? 'bg-blue-500' : 'bg-blue-200' }}">
    <h1 class="md:text-sm font-bold text-xs text-white">
        <div class="flex items-center gap-2">
            {{ $slot }}
        </div>
    </h1>
</section>