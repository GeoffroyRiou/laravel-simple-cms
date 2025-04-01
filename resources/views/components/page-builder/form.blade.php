@props([
    'content' => '',
    'bgColor' => '',
    'bgColorInner' => '',
    'darkMode' => false,
    'spacer' => '',
])

<section class="{{ $spacer }} {{ $bgColor }} {{ $darkMode ? 'dark' : '' }} ">
    <div class="simple-cms-content xl:max-w-6/12 mx-auto {{ $bgColorInner }} {{ $bgColorInner ? 'p-8 rounded-lg' : '' }}">
        @livewire('contact-form', ['formId' => $content])
    </div>
</section>