@props(['article'])

<article class="border border-dark/20 p-5 bg-light">
    <div class="flex flex-col gap-3">

        @if (!empty($article->illustration))
            <x-image :path="$article->illustration" width="400" height="400" crop="true" />
        @endif

        @if (!empty($article->category))
            <div class="flex items-center gap-2">
                <span class="p-1 bg-dark text-light rounded text-xs">{{ $article->category->title }}</span>
            </div>
        @endif

        <x-headings.h3 title="{{ $article->title }}" />

        @if (!empty($article->excerpt))
            <p class="text-sm">{{ $article->excerpt }}</p>
        @endif

    </div>

</article>
