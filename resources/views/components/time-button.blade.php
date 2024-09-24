@props(['active' => false])

<button {{ $attributes->merge(['class' => 'cursor-pointer w-auto border border-gray-300 rounded-lg px-4 py-2 font-bold ' . ($active ? 'bg-blue-500 text-white' : 'bg-white text-gray-700 hover:bg-gray-100')]) }}>
    {{ $slot }}
</button>