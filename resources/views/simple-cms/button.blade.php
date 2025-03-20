@use('Illuminate\View\ComponentAttributeBag')

@if (!empty($data['url']))
    @php
        extract($data);
        $class = 'inline-flex items-center justify-between gap-3 rounded-sm border px-8 py-3 focus:ring-3 focus:outline-hidden w-fit ';

        $class .= !empty($data['iconReverse']) ? 'flex-row-reverse' : '';

        switch ($variant ?? 'primary') {
            case 'primary':
                $class .= ' border border-indigo-600 bg-indigo-600 text-white hover:bg-transparent hover:text-indigo-600';
                break;
            case 'primary-invert':
                $class .=
                    ' border border-indigo-600 bg-white text-indigo-600 hover:bg-indigo-600 hover:border-white hover:text-white';
                break;
        }
    @endphp
    <a {{ $attributes->merge(['class' => $class]) }}
        href="{{ $url }}" {{ $blank ? 'target="_blank"' : '' }}>
        <span class="text-sm font-medium"> {{ $label }} </span>

        @if (!empty($icon))
            <x-dynamic-component :component="$icon" class="h-4 w-4" />
        @endif
    </a>
@endif
