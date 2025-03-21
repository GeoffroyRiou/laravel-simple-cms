@props(['path', 'sizes' => []])
@use('App\Facades\SimpleCmsImage')

@if (!empty($sizes))
    @php
        $defaultSize = $sizes[0];
    @endphp
    <picture>
        @foreach ($sizes as $size)
            <source srcset="{{ SimpleCmsImage::imageUrl($path, $size['width'], $size['height'], $size['crop']) }}"
                media="({{ $size['breakpoint'] }})" />
        @endforeach
        <img src="{{ SimpleCmsImage::imageUrl($path, $defaultSize['width'], $defaultSize['height'], $defaultSize['crop']) }}"
            loading="lazy" {{ $attributes->merge(['class' => '']) }} width={{ $defaultSize['width'] }}
            height={{ $defaultSize['height'] }} />
    </picture>
@endif
