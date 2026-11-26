<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
    <div>
        <h2 class="text-2xl text-slate-800 dark:text-slate-100 font-bold mb-2">
            {{ __('Order') }} #{{ $order->order_id ?? $order->id }}
        </h2>
        <ul class="inline-flex flex-wrap text-sm font-medium">
            <li class="flex items-center">
                <a class="text-slate-500 hover:text-indigo-500" wire:navigate href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                <svg class="h-4 w-4 fill-current text-slate-400 mx-3" viewBox="0 0 16 16"><path d="M6.6 13.4L5.2 12l4-4-4-4 1.4-1.4L12 8z" /></svg>
            </li>
            <li class="flex items-center">
                <a class="text-slate-500 hover:text-indigo-500" wire:navigate href="{{ route('admin.orders.index') }}">{{ __('Orders') }}</a>
                <svg class="h-4 w-4 fill-current text-slate-400 mx-3" viewBox="0 0 16 16"><path d="M6.6 13.4L5.2 12l4-4-4-4 1.4-1.4L12 8z" /></svg>
            </li>
            <li class="flex items-center">
                <span class="text-indigo-500">#{{ $order->order_id ?? $order->id }}</span>
            </li>
        </ul>
    </div>

    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-slate-800 shadow rounded-md p-5 space-y-3">
            <h3 class="font-semibold text-slate-800 dark:text-slate-100">{{ __('Summary') }}</h3>
            <p><span class="text-slate-500">{{ __('Status') }}:</span> {{ $order->status }}</p>
            <p><span class="text-slate-500">{{ __('Amount') }}:</span> {{ $order->formatted_amount }}</p>
            <p><span class="text-slate-500">{{ __('Business') }}:</span> {{ $order->business?->name ?? '—' }}</p>
            <p><span class="text-slate-500">{{ __('Shop') }}:</span> {{ $order->shop?->name ?? '—' }}</p>
            <p><span class="text-slate-500">{{ __('Created') }}:</span> {{ optional($order->created_at)->format('d/m/Y H:i') }}</p>
        </div>

        <div class="bg-white dark:bg-slate-800 shadow rounded-md p-5 space-y-3">
            <h3 class="font-semibold text-slate-800 dark:text-slate-100">{{ __('Customer') }}</h3>
            <p><span class="text-slate-500">{{ __('Name') }}:</span> {{ $order->customer?->name ?? '—' }}</p>
            <p><span class="text-slate-500">{{ __('Email') }}:</span> {{ $order->customer?->email ?? '—' }}</p>
            <p><span class="text-slate-500">{{ __('Phone') }}:</span> {{ $order->customer?->phone ?? '—' }}</p>
            <p><span class="text-slate-500">{{ __('Delivery') }}:</span> {{ $order->delivery_address?->address ?? '—' }}</p>
        </div>
    </div>

    <div class="mt-6 bg-white dark:bg-slate-800 shadow rounded-md p-5">
        <h3 class="font-semibold text-slate-800 dark:text-slate-100 mb-4">{{ __('Items') }}</h3>
        <div class="overflow-x-auto">
            <table class="table-auto w-full dark:text-slate-300">
                <thead class="text-xs uppercase text-slate-400 bg-slate-50 dark:bg-slate-700 dark:bg-opacity-50 rounded-sm">
                    <tr>
                        <th class="p-2 text-left">{{ __('Product') }}</th>
                        <th class="p-2 text-left">{{ __('Qty') }}</th>
                        <th class="p-2 text-left">{{ __('Status') }}</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-100 dark:divide-slate-700">
                    @forelse ($order->items as $item)
                        <tr>
                            <td class="p-2">{{ $item->product?->name ?? ('#'.$item->item_id) }}</td>
                            <td class="p-2">{{ $item->quantity }}</td>
                            <td class="p-2">{{ $item->status }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="p-4 text-slate-500">{{ __('No items found.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
