<?php

declare(strict_types=1);

?>
@use('Illuminate\View\ComponentAttributeBag')

@if (!empty($data['url']))
    @php
        extract($data);

        $class = $variant . ' ';

        // Shape
        $class .= 'inline-flex items-center gap-3 rounded-sm border px-8 py-3 focus:ring-3 focus:outline-hidden w-fit transition-colors duration-300';

        // Light
        $class .= 'border-primary bg-light text-primary hover:bg-primary hover:text-light ';

        // Dark
        $class .=
            'buttondark:border-light buttondark:bg-primary buttondark:text-light buttondark:hover:bg-light buttondark:hover:border-primary buttondark:hover:text-primary ';

        $class .= !empty($data['iconReverse']) ? 'flex-row-reverse ' : '';

        $class .= !empty($icon) ? 'justify-between ' : 'justify-center ';
    @endphp
    <a {{ $attributes->merge(['class' => $class]) }} href="{{ $url }}" {{ $blank ? 'target="_blank"' : '' }}>
        <span class="text-sm font-medium"> {{ $label }} </span>

        @if (!empty($icon))
            <x-dynamic-component :component="$icon" class="h-4 w-4" />
        @endif
    </a>
@endif
<?php 
