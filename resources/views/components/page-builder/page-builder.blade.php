<?php

declare(strict_types=1);

?>
@use('Illuminate\View\ComponentAttributeBag')


@foreach ($blocks as $index => $block)
    @php
        $component = $block['type'];
        $block['data']['index'] = $index;
        $attributes = new ComponentAttributeBag($block['data']);
    @endphp
    <x-dynamic-component :$component :$attributes/>
@endforeach
<?php 
