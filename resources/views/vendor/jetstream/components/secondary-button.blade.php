<button {{ $attributes->merge(['type' => 'button', 'class' => 'ml-2 px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition-colors duration-150 bg-white border border-gray-300 rounded-lg active:text-gray-800 active:bg-gray-50 hover:text-gray-500 focus:outline-none focus:shadow-outline-purple']) }}>
    {{ $slot }}
</button>
