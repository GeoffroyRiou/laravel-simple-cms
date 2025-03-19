@props(['path', 'width' => 100, 'height' => 100, 'crop' => false])
@use('App\Facades\SimpleCmsImage')

<img src="{{ SimpleCmsImage::imageUrl($path, $width, $height, $crop) }}" {{ $attributes->merge(['loading' => 'lazy']) }} />
