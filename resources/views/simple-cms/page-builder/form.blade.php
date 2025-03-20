@props([
    'content' => '',
    'bgColor' => '',
    'bgColorInner' => '',
])

<section class="p-5 {{ $bgColor }} ">
    <div class="simple-cms-content xl:max-w-6/12 mx-auto {{ $bgColorInner }} {{ $bgColorInner ? 'p-8 rounded-lg lg:p-16' : '' }}">
        @livewire('contact-form', ['formId' => $content])
    </div>
</section>