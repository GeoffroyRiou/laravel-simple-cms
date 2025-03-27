@props(['article'])

<article class="article-card">
    <div class="content">

        @if (!empty($article->illustration))
            <x-simple-cms::image :path="$article->illustration" width="400" height="400" crop="true" />
        @endif

        @if (!empty($article->category))
            <div class="article-card__categories">
                <span class="category">{{ $article->category->title }}</span>
            </div>
        @endif


        <h3 class="title">{{ $article->title }}</h3>

        @if (!empty($article->excerpt))
            <p class="text">{{ $article->excerpt }}</p>
        @endif

    </div>

</article>
