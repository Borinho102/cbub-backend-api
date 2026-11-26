<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
    <div>
        <h2 class="text-2xl text-slate-800 dark:text-slate-100 font-bold mb-2">
            {{ __('Customer Details') }}
        </h2>
        <ul class="inline-flex flex-wrap text-sm font-medium">
            <li class="flex items-center">
                <a class="text-slate-500 hover:text-indigo-500" wire:navigate href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                <svg class="h-4 w-4 fill-current text-slate-400 mx-3" viewBox="0 0 16 16"><path d="M6.6 13.4L5.2 12l4-4-4-4 1.4-1.4L12 8z" /></svg>
            </li>
            <li class="flex items-center">
                <a class="text-slate-500 hover:text-indigo-500" wire:navigate href="{{ route('admin.customers.index') }}">{{ __('Customers') }}</a>
                <svg class="h-4 w-4 fill-current text-slate-400 mx-3" viewBox="0 0 16 16"><path d="M6.6 13.4L5.2 12l4-4-4-4 1.4-1.4L12 8z" /></svg>
            </li>
            <li class="flex items-center">
                <span class="text-indigo-500">{{ $customer->user?->name ?? __('Customer') }}</span>
            </li>
        </ul>
    </div>

    <div class="mt-6 bg-white dark:bg-slate-800 shadow rounded-md p-5 space-y-3">
        <h3 class="font-semibold text-slate-800 dark:text-slate-100">{{ __('Profile') }}</h3>
        <p><span class="text-slate-500">{{ __('Name') }}:</span> {{ $customer->user?->name ?? '—' }}</p>
        <p><span class="text-slate-500">{{ __('Email') }}:</span> {{ $customer->user?->email ?? '—' }}</p>
        <p><span class="text-slate-500">{{ __('Phone') }}:</span> {{ $customer->user?->phone ?? '—' }}</p>
        <p><span class="text-slate-500">{{ __('Business ID') }}:</span> {{ $customer->business_id ?? '—' }}</p>
    </div>

    <div class="mt-6 bg-white dark:bg-slate-800 shadow rounded-md p-5">
        <h3 class="font-semibold text-slate-800 dark:text-slate-100 mb-4">{{ __('Recent Orders') }}</h3>
        <div class="overflow-x-auto">
            <table class="table-auto w-full dark:text-slate-300">
                <thead class="text-xs uppercase text-slate-400 bg-slate-50 dark:bg-slate-700 dark:bg-opacity-50 rounded-sm">
                    <tr>
                        <th class="p-2 text-left">{{ __('Order') }}</th>
                        <th class="p-2 text-left">{{ __('Amount') }}</th>
                        <th class="p-2 text-left">{{ __('Status') }}</th>
                        <th class="p-2 text-left">{{ __('Date') }}</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-100 dark:divide-slate-700">
                    @forelse ($customer->orders as $order)
                        <tr>
                            <td class="p-2">
                                <a class="text-indigo-500 hover:underline" wire:navigate href="{{ route('admin.orders.show', $order) }}">
                                    #{{ $order->order_id ?? $order->id }}
                                </a>
                            </td>
                            <td class="p-2">{{ $order->formatted_amount }}</td>
                            <td class="p-2">{{ $order->status }}</td>
                            <td class="p-2">{{ optional($order->created_at)->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-4 text-slate-500">{{ __('No orders found.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
