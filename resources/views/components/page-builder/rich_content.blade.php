@props([
    'content' => '',
    'bgColor' => '',
    'bgColorInner' => '',
    'darkMode' => false,
    'textCentered' => false,
    'topSpacer' => '',
    'bottomSpacer' => '',
])

<section class="{{ $topSpacer }} {{ $bottomSpacer }} {{ $bgColor }}">
    <div class="simple-cms-content px-5 {{ $darkMode ? 'dark' : '' }} {{ $textCentered ? 'text-center xl:max-w-6/12' : 'xl:max-w-10/12' }} mx-auto {{ $bgColorInner }} {{ $bgColorInner ? 'p-8 rounded-lg' : '' }} text-dark dark:text-light">
        {!! $content !!}
    </div>
</section>