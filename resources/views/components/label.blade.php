@props(['isRequired' => true])
<label {{ $attributes->merge(['class' => 'text-xs text-gray-500'])}}>
    {{ $slot }}@if($isRequired) <span class="text-red-500">*</span> @endif
</label>