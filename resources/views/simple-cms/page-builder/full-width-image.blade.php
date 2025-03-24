@props([
    'image' => null,
    'bgColor' => '',
    'index' => 0,
    'spacer' => '',
])

<section class="{{ $bgColor }} {{ $spacer }}">
    <div class="{{ $bgColor ? 'mx-auto xl:max-w-10/12' : '' }}">
        <x-simple-cms::picture class="{{ $bgColor ? 'rounded-lg' : '' }}" :path="$image" :sizes="[
            ['breakpoint' => '', 'width' => 760, 'height' => 400, 'crop' => true],
            ['breakpoint' => 'min-width:760px', 'width' => 1920, 'height' => 500, 'crop' => true],
        ]" :$index/>
    </div>
</section>
