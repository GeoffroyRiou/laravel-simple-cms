<?php

declare(strict_types=1);

?>
@php($languagesAvailable = config('app.locales'))
@php($currentLocale = LaravelLocalization::getCurrentLocale())
@if (count($languagesAvailable) > 1)
    <ul class="flex gap-2">
        @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
            <li>
                <a rel="alternate" hreflang="{{ $localeCode }}"
                    class="w-8 h-8 flex items-center justify-center bg-light text-dark p-1 rounded-md {{ $currentLocale === $localeCode ? 'bg-primary text-light' : '' }}"
                    href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                    {{ $properties['native'] }}
                </a>
            </li>
        @endforeach
    </ul>
@endif
<?php 
