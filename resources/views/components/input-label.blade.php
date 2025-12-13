@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-semibold text-sm text-[#1b1b18] dark:text-[#EDEDEC]']) }}>
    {{ $value ?? $slot }}
</label>
