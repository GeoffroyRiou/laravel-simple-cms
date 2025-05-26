@use('App\Facades\SimpleCmsImage')
@props(['path'])

<x-filament::avatar
    loading="lazy"
    src="{{ SimpleCmsImage::isResizable($path) ? SimpleCmsImage::imageUrl($path, 100, 100, true) : '' }}"
    :circular="false" alt="" size="w-24 h-24" />
