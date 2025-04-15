<?php

declare(strict_types=1);

?>
@props(['setting'])

<div {{ $attributes->merge(['class' => 'flex items-center gap-2 group']) }}>
    @if (!empty($setting['icon']))
        <x-dynamic-component :component="$setting['icon']" class="h-4 w-4" />
    @endif
    @switch($setting['type'])
        @case('Email')
        @case('Phone')
            <a href="{{ $setting['type'] == 'Phone' ? 'tel' : 'mailto' }}:{{ $setting['value'] }}"
                class="text-sm font-medium hover:text-primary">{{ $setting['value'] }}</a>
        @break

        @case('Text area')
            <p class="text-sm font-medium">{!! nl2br($setting['value']) !!}</p>
        @break

        @default
            <p class="text-sm font-medium">{{ $setting['value'] }}</p>
        @break
    @endswitch
</div>
<?php 
