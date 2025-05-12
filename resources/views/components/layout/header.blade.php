<?php

declare(strict_types=1);

?>


<header class="g-header" :class="{ 'is-sticky': !atTop }" x-data="{ atTop: true, showMenu: false }" @scroll.window="atTop = (window.pageYOffset < 64) ? true : false;">

    <div class="g-header__row is-firstrow" :class="{ 'is-sticky': !atTop }">
        <div class="inner">
            <x-contact-stripe class="is-inline"/>

            <div class="g-header__actions -desktop">
                <x-menu :menuId="1" class="g-header__top-bar-menu" />
                <a href="{{$settings['linkedin']->value ?? ''}}" class="g-header__actions__linkedin" target="_blank">
                    <x-icon-linkedin-circle />
                </a>
                <x-language-switcher class="is-dark"/>
            </div>
        </div>
    </div>

    <div class="g-header__row is-secondrow">
        <div class="inner">
            <a href="{{ LaravelLocalization::localizeUrl('/') }}" class="g-header__logo" :class="{ 'is-sticky': !atTop }" aria-label="Accueil">
                <img src="{{asset('images/logo.svg')}}" alt="Cyclhad" class="logo">
            </a>

            <div>
                <x-layout.header-menu />
            </div>

            <div class="g-header__actions -mobile">
                <a href="tel:{{$settings['telephone']->value ?? ''}}" class="g-header__actions__action -primary" aria-label="Numéro de téléphone">
                    <x-icon-phone class="icon" />
                </a>
                <button type="button" aria-label="Ouvrir le menu" class="g-header__actions__action -secondary" x-on:click="showMenu = true">
                    <span class="text">Menu</span>
                    <x-icon-burger class="icon -burger" />
                </button>
            </div>
        </div>
    </div>
</header>
<?php
