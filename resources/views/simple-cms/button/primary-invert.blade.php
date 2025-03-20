<a {{ $attributes->merge(['class' => 'inline-flex items-center justify-center gap-2 rounded-sm border border-indigo-600 bg-white px-8 py-3 text-indigo-600 hover:bg-indigo-600 hover:border-white hover:text-white focus:ring-3 focus:outline-hidden w-fit']) }}
    href="{{ $url }}" {{ $blank ? 'target="_blank"' : '' }}>
    <span class="text-sm font-medium"> {{ $label }} </span>
</a>
