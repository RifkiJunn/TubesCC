<button {{ $attributes->merge([
    'type' => 'submit', 
    'class' => 'inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-[#f53003] via-[#ff6b3d] to-[#ff8c66] border border-transparent rounded-xl font-semibold text-sm text-white uppercase tracking-wide hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-[#f53003] focus:ring-offset-2 active:opacity-90 transition-all duration-300 hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed'
]) }}>
    {{ $slot }}
</button>
