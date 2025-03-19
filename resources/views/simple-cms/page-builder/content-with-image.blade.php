@props([
    'image' => null,
    'image_full' => false,
    'image_right' => false,
    'bgColor' => 'bg-white',
    'textColor' => 'text-slate-900',
    'title' => '',
    'text' => '',
    'url' => '',
    'label' => '',
    'blank' => '',
    'button' => null,
])

<section class="{{ $bgColor }}">
    <div
        class="flex flex-col gap-5 md:grid md:grid-cols-2 md:items-center {{ $image_full ? 'md:gap-0' : 'max-w-[1400px] p-5 mx-auto md:gap-10 lg:gap-16' }}">
        @if (!empty($image))
            <figure class="{{ $image_right ? 'md:order-2' : '' }}">
                <x-simple-cms::image :path="$image" width="800" height="700" crop="true"
                    class="{{ $image_full ? 'w-full h-full object-cover' : 'rounded-md' }}" />
            </figure>
        @endif
        <div class="flex-1 lg:px-16  {{ $image_full ? 'pb-5 px-5' : '' }}  {{ $image_right ? 'md:order-1' : '' }}">
            <div class="flex flex-col gap-5 md:gap-5 max-w-[500px] {{ $textColor }}">
                <x-simple-cms::headings.h2 :$title />

                <div>
                    {!! $text !!}
                </div>

                <x-simple-cms::button variant="button-primary" :data="$button"/>
            </div>
        </div>
    </div>
</section>
