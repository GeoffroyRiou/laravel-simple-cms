<?php

declare(strict_types=1);

?>
@props([
    'bgColor' => '',
    'topSpacer' => '',
    'bottomSpacer' => '',
    'buttons' => []
])

<section class="{{ $bgColor }} {{ $topSpacer }} {{ $bottomSpacer }}">
    <div class="mx-auto px-5 flex flex-col gap-2 md:flex-row md:justify-center xl:max-w-10/12">
        @foreach ($buttons as $button)
            <x-button :data="$button" class="w-full md:w-fit"/>
        @endforeach
    </div>
</section><?php 
