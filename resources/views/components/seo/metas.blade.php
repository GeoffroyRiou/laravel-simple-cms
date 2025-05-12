@use('App\Facades\SimpleCmsImage')
@props([
    'model'
])

@php
    $seoTitle = $model->seo_title ?? $settings['seo_title']['value'] ?? config('app.name') ?? '';
    $seodescription = $model->seo_description ?? $settings['seo_description']['value'] ?? '';
    $seoIllustation = $model->illustration ? SimpleCmsImage::imageUrl($model->illustration, 1200,628, true) : asset('images/default-illustration-meta.svg');
@endphp

<title>{{ $seoTitle }}</title>
<meta name="description" content="{{ $seodescription }}">
<meta property="og:title" content="{{ $seoTitle }}">
<meta property="og:description" content="{{ $seodescription }}">
<meta property="og:locale" content="{{ app()->getLocale() }}">
<meta property="og:url" content="{{ Request::url() }}">
<meta property="og:illustration" content="{{ $seoIllustation }}">
<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="{{ $seoTitle }}">
<meta name="twitter:description" content="{{ $seodescription }}">