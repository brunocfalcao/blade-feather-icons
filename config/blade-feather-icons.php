<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Icon Prefix
    |--------------------------------------------------------------------------
    |
    | This value is used as the prefix for all Feather Icons components.
    | You can customize this to avoid conflicts with other icon sets.
    |
    | Example: 'feather' will generate <x-feather-home />
    |
    */

    'prefix' => 'feathericon',

    /*
    |--------------------------------------------------------------------------
    | Fallback Icon
    |--------------------------------------------------------------------------
    |
    | This icon will be used when a requested icon is not found.
    | Leave empty to throw an exception instead.
    |
    */

    'fallback' => '',

    /*
    |--------------------------------------------------------------------------
    | Default Class
    |--------------------------------------------------------------------------
    |
    | This class will be applied to all Feather Icons by default.
    | Useful for consistent sizing or styling across your application.
    |
    | Example: 'w-5 h-5' for Tailwind CSS
    |
    */

    'class' => '',

    /*
    |--------------------------------------------------------------------------
    | Default Attributes
    |--------------------------------------------------------------------------
    |
    | These HTML attributes will be applied to all icons by default.
    | You can override them on individual components.
    |
    */

    'attributes' => [
        // 'width' => 24,
        // 'height' => 24,
        // 'aria-hidden' => 'true',
    ],

];
