@props([
    'bgColor' => '',
    'text' => '',
    'textColor' => '',
    'size' => '',
])

<div class="{{ $size }} {{ $bgColor }}">

    @if ($text)
        <span class="flex items-center max-w-10/12 mx-auto">
            <span class="h-px flex-1 bg-slate-400/30"></span>

            <span class="shrink-0 px-4 {{ $textColor }}">{{ $text }}</span>

            <span class="h-px flex-1 bg-slate-400/30"></span>
        </span>
    @endif
</div>
