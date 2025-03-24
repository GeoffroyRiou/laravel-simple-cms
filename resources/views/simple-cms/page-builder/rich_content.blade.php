@props([
    'content' => '',
    'bgColor' => '',
    'bgColorInner' => '',
    'darkMode' => false,
    'textCentered' => false,
])

<section class="p-5 {{ $bgColor }} {{ $textCentered ? 'mx-auto text-center xl:max-w-6/12' : '' }} ">
    <div class="simple-cms-content {{ $darkMode ? 'dark' : '' }} xl:max-w-10/12 mx-auto {{ $bgColorInner }} {{ $bgColorInner ? 'p-8 rounded-lg' : '' }} text-dark dark:text-light">
        {!! $content !!}
    </div>
</section>