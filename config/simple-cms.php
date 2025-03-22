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
    ],


    /**
     * Spacer sizes
     * Used for the page builder blocks
     * ex: 'py-2.5' => 'Small',
     * Key is the css classes that will be applied
     */
    'spacers' => [
        'py-2.5' => 'S',
        'py-2.5 md:py-5' => 'M',
        'py-5 md:py-8' => 'L',
        'py-8 md:py-14' => 'XL',
        'py-14 md:py-16' => 'XXL',
    ],

    'home_view_name' => 'simple-cms.pages.home'
];
