<?php

declare(strict_types=1);

?>
@props([
    'bgColor' => '',
    'darkMode' => false,
    'title' => '',
    'text' => '',
    'button' => [],
    'topSpacer' => '',
    'bottomSpacer' => '',
])

@php
    $articles = App\Models\Article::published()->with('category')->orderBy('created_at', 'desc')->take(2)->get();
@endphp

<section
    class=" flex flex-col gap-5 px-5 lg:flex-row {{ $bgColor }} {{ $darkMode ? 'dark' : '' }} {{ $topSpacer }} {{ $bottomSpacer }}">
    
    <div class="max-w-10/12 mx-auto flex flex-col gap-10 lg:flex-row lg:gap-20">
        <div class="flex flex-col items-center gap-3 lg:items-start lg:min-w-[300px] shrink-0">
            <div class="relative flex justify-center w-full max-w-[200px] mx-auto lg:justify-start lg:flex-wrap lg:max-w-none lg:gap-3">
                <x-headings.h2 :$title class="text-dark dark:text-light" />
            </div>
            <div class="text-dark dark:text-light italic text-center max-w-[500px] mx-auto lg:ml-0 lg:text-left">
                {!! $text ?? '' !!}
            </div>
            <x-button :data="$button" />
        </div>
        <div class="flex flex-col gap-5 sm:flex-row sm:justify-center lg:justify-end">
            @foreach ($articles as $article)
                <x-articles.article-card :$article />
            @endforeach
        </div>
    </div>
</section>
<?php 
