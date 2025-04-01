@props([
    'bgColor' => '',
    'darkMode' => false,
    'title' => '',
    'text' => '',
    'button' => [],
    'spacer' => '',
])

@php
    $articles = App\Models\Article::published()->with('category')->orderBy('created_at', 'desc')->take(2)->get();
@endphp

<section class="cms-last-articles {{ $bgColor }} {{ $darkMode ? 'dark' : '' }} {{ $spacer }}">
    <div class="cms-last-articles__content">
        <div class="head">
            <x-headings.h2 :$title class="text-dark dark:text-light" />
        </div>
        <div class="text-dark dark:text-light">
            {!! $text ?? '' !!}
        </div>
        <x-button :data="$button"/>
    </div>
    <div class="cms-last-articles__articles">
        @foreach ($articles as $article)
            <x-articles.article-card :$article />
        @endforeach
    </div>
</section>
