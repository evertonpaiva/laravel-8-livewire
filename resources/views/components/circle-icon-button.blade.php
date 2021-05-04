<button {{ $attributes->merge(['type' => 'submit', 'class' => 'flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-full active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple']) }}>
    <i class="{{ $icon }}"></i>
</button>
