<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white whitespace-nowrap rounded']) }}>
    {{ $slot }}
</button>
