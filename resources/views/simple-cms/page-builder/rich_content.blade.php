@props([
    'content' => '',
    'bgColor' => '',
    'bgColorInner' => '',
    'textColor' => 'text-slate-900',
    'textCentered' => false,
])

<section class="p-5 lg:py-16 {{ $bgColor }} {{ $textCentered ? 'text-center' : '' }} ">
    <div class="simple-cms-content xl:max-w-10/12 mx-auto {{ $bgColorInner }} {{ $bgColorInner ? 'p-8 rounded-lg' : '' }} {{ $textColor }}">
        {!! $content !!}
    </div>
</section>