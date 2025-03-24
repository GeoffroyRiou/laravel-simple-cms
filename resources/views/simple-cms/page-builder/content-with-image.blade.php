@props([
    'image' => null,
    'image_full' => false,
    'image_right' => false,
    'bgColor' => '',
    'darkMode' => false,
    'title' => '',
    'text' => '',
    'url' => '',
    'label' => '',
    'blank' => '',
    'button' => [],
    'spacer' => '',
])

<section class="{{ $bgColor }} {{ $darkMode ? 'dark' : '' }} {{ $spacer }}">
    <div
        class="flex flex-col gap-5 md:grid md:grid-cols-2 md:items-center {{ $image_full ? 'md:gap-0' : 'xl:max-w-10/12 mx-auto md:gap-10 lg:gap-16' }}">
        @if (!empty($image))
            <figure class="{{ $image_right ? 'md:order-2' : '' }}">
                <x-simple-cms::image :path="$image" width="800" height="700" crop="true"
                    class="{{ $image_full ? 'w-full h-full object-cover' : 'rounded-md' }}" />
            </figure>
        @endif
        <div class="flex-1 lg:px-16  {{ $image_full ? 'pb-5 px-5' : '' }}  {{ $image_right ? 'md:order-1' : '' }}">
            <div class="flex flex-col gap-5 md:gap-5 max-w-[500px] text-dark dark:text-light">
                <x-simple-cms::headings.h2 :$title />

                <div class="simple-cms-content">
                    {!! $text !!}
                </div>

                <x-simple-cms::button :data="$button"/>
            </div>
        </div>
    </div>
</section>
