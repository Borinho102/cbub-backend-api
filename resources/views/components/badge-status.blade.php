@props(['status', 'label'])

@if (isset($status))
    @if ($status == 1 || $status === 'complete')
        <div class="text-xs inline-flex font-medium rounded-full text-center px-2.5 py-1 bg-emerald-100 dark:bg-emerald-400/30 text-emerald-600 dark:text-emerald-400">{{ $label ?? $slot }}</div>
    @elseif ($status == 0 || $status === 'pending')
        <div class="inline-flex font-medium rounded-full text-center px-2.5 py-0.5 bg-amber-100 dark:bg-amber-400/30 text-amber-600 dark:text-amber-400">{{ $label ?? $slot }}</div>
    @elseif ($status == 'cancelled' || $status == 'canceled')
        <div class="inline-flex font-medium rounded-full text-center px-2.5 py-0.5 bg-rose-100 dark:bg-rose-500/30 text-rose-500 dark:text-rose-400">{{ $label ?? $slot }}</div>
    @elseif ($status === 'approved')
        <div class="inline-flex font-medium rounded-full text-center px-2.5 py-0.5 bg-emerald-100 dark:bg-emerald-400/30 text-emerald-600 dark:text-emerald-400">{{ $label ?? $slot }}</div>
    @elseif ($status === 'refunded')
        <div class="inline-flex font-medium rounded-full text-center px-2.5 py-0.5 bg-sky-100 dark:bg-sky-400/30 text-sky-600 dark:text-sky-400">{{ $label ?? $slot }}</div>
    @else
        <div class="inline-flex font-medium rounded-full text-center px-2.5 py-0.5 bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400">{{ $label ?? $slot }}</div>
    @endif
@else
    <div class="inline-flex font-medium rounded-full text-center px-2.5 py-0.5 bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400">{{ $label ?? $slot }}</div>
@endif
