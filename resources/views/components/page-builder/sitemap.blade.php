@props([
    'content' => '',
    'topSpacer' => '',
    'bottomSpacer' => '',
])
@php
    $sitemapService = app('sitemap');
@endphp

<section class="{{ $topSpacer }} {{ $bottomSpacer }}">
    <div class="simple-cms-content px-5 mx-auto">
        {!! $sitemapService->generateHTMLSitemap() !!}
    </div>
</section>
