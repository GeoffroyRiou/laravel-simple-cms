@use('App\Facades\SimpleCmsImage')
@props(['path'])

@if (SimpleCmsImage::isResizable($path))
    <x-filament::avatar {{ $attributes }} loading="lazy" src="{{ SimpleCmsImage::imageUrl($path, 100, 100, true) }}"
        :circular="false" alt="" size="w-24 h-24" />
@else
    <div class="media-preview-file">
        @if (SimpleCmsImage::isSVG($path))
            <img src="{{ SimpleCmsImage::getOriginalUrl($path) }}" alt="">
        @else
            <x-icon-document class="icon" />
        @endif
    </div>
@endif
