<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-gradient-to-r from-amber-400 to-orange-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:from-amber-500 hover:to-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 active:from-amber-600 active:to-orange-800 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
