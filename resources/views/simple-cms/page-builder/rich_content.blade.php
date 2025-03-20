@props([
    'content' => '',
    'bgColor' => '',
    'bgColorInner' => '',
    'textColor' => 'text-indigo-950',
    'textCentered' => false,
])

<section class="p-5 lg:py-16 {{ $bgColor }} {{ $textCentered ? 'mx-auto text-center xl:max-w-6/12' : '' }} ">
    <div class="simple-cms-content xl:max-w-10/12 mx-auto {{ $bgColorInner }} {{ $bgColorInner ? 'p-8 rounded-lg' : '' }} {{ $textColor }}">
        {!! $content !!}
    </div>
</section>