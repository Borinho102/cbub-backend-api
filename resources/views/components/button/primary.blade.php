<button {{ $attributes->merge(['class' => 'inline-flex items-center justify-center px-4 py-2 rounded-md font-semibold text-xs text-white uppercase tracking-widest bg-indigo-500 hover:bg-indigo-600 text-white whitespace-nowrap']) }}>
    {{ $slot }}
</button>
