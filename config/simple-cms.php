<?php

declare(strict_types=1);

return [
    /**
     * Namespace of the custom page builder blocks
     * ex: "App\\Filament\\Blocks"
     */
    'blocks' => [
        'App\\Filament\\Blocks',
    ],

    /**
     * Your models folders paths
     * (Used for the menus)
     * ex: app_path('Models')
     */
    'model_paths' => [
        //
    ],

    /**
     * Background colors
     * Used for the page builder blocks
     * ex: 'bg-slate-100' => 'Gray'
     * Key is the css class that will be applied
     */
    'bgColors' => [
        'bg-primary' => 'Couleur principale',
        'bg-dark' => 'Couleur foncée',
        'bg-light' => 'Couleur claire',
    ],

    /**
     * Available icons with blade icon package
     * Used for the page builder blocks
     * ex: 'icon-arrow-right' => 'Arrow',
     * Key is the component name
     */
    'icons' => [
        'icon-arrow-right' => 'Flèche',
        'icon-download' => 'Téléchargement',
        'icon-mail' => 'Email',
        'icon-phone' => 'Téléphone',
        'icon-pinmap' => 'Marqueur',
    ],

    /**
     * Spacer sizes
     * Used for the page builder blocks
     * ex: 'py-2.5' => 'Small',
     * Key is the css classes that will be applied
     */
    'spacers' => [
        'top' => [
            'pt-2.5' => 'S',
            'pt-2.5 md:pt-5' => 'M',
            'pt-5 md:pt-8' => 'L',
            'pt-8 md:pt-14' => 'XL',
            'pt-14 md:pt-16' => 'XXL',
        ],
        'bottom' => [
            'pb-2.5' => 'S',
            'pb-2.5 md:pb-5' => 'M',
            'pb-5 md:pb-8' => 'L',
            'pb-8 md:pb-14' => 'XL',
            'pb-14 md:pb-16' => 'XXL',
        ],
    ],

    'home_view_name' => 'components.pages.home',
];
