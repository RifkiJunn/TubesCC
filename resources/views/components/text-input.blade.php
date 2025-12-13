@props(['disabled' => false])

<input 
    @disabled($disabled) 
    {{ $attributes->merge([
        'class' => 'border-[#e3e3e0] dark:border-[#3E3E3A] focus:border-[#f53003] dark:focus:border-[#FF4433] focus:ring-[#f53003] dark:focus:ring-[#FF4433] rounded-lg shadow-sm bg-white dark:bg-[#161615] text-[#1b1b18] dark:text-[#EDEDEC] placeholder:text-[#706f6c] dark:placeholder:text-[#A1A09A] transition-colors duration-200'
    ]) }}
>
