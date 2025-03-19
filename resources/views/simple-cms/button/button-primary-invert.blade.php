<a {{ $attributes->merge(['class' => 'inline-flex items-center gap-2 rounded-sm border border-indigo-600 bg-white px-8 py-3 text-indigo-600 hover:bg-indigo-50 focus:ring-3 focus:outline-hidden w-fit']) }}
    href="{{ $url }}" {{ $blank ? 'target="_blank"' : '' }}>
    <span class="text-sm font-medium"> {{ $label }} </span>

    <svg class="size-5 rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
        stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
    </svg>
</a>
