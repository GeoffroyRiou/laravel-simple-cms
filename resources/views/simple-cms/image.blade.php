@use('App\Facades\SimpleCmsImage')
@props(['path', 'width' => 100, 'height' => 100, 'crop' => false])

<img src="{{ SimpleCmsImage::imageUrl($path, $width, $height, $crop) }}" {{ $attributes->merge(['loading' => 'lazy']) }}
    width="{{ $width }}" height="{{ $height }}" />
