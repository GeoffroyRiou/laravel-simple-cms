@props([
    'topSpacer' => '',
    'bottomSpacer' => '',
])

<section class="{{ $topSpacer }} {{ $bottomSpacer }} bg-light">
    <div class="px-5 lg:max-w-8/12 mx-auto">
        <livewire:articles-list />
    </div>
</section>