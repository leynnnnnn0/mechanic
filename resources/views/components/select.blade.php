<select {{ $attributes->merge(['class' => 'border border-black/10 rounded-lg h-10 px-3'])}}>
    <option value="">Select from options</option>
    {{ $slot }}
</select>