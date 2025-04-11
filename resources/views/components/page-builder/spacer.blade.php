@props([
    'bgColor' => '',
    'text' => '',
    'darkMode' => false,
    'topSpacer' => '',
    'bottomSpacer' => '',
])

<div class="{{ $topSpacer }} {{ $bottomSpacer }} {{ $bgColor }} {{ $darkMode ? 'dark' : '' }}">

    @if ($text)
        <span class="flex items-center max-w-10/12 mx-auto">
            <span class="min-w-5 h-px flex-1 bg-dark/30 dark:bg-light/30"></span>

            <span class="text-center px-4 uppercase tracking-widest text-xs text-dark dark:text-light">{{ $text }}</span>

            <span class="min-w-5 h-px flex-1 bg-dark/30 dark:bg-light/30"></span>
        </span>
    @endif
</div>
