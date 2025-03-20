<a {{ $attributes->merge(['class' => 'inline-flex items-center gap-2 rounded-sm border border-indigo-600 bg-indigo-600 px-8 py-3 text-white hover:bg-transparent hover:text-indigo-600 focus:ring-3 focus:outline-hidden w-fit']) }} href="{{ $url }}" {{ $blank ? 'target="_blank"' : '' }}>
    <span class="text-sm font-medium"> {{ $label }} </span>
</a>