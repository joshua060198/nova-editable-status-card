<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Status Type
    |--------------------------------------------------------------------------
    |
    | This option defines the the container for status information. You may
    | select between "class" and "array". 
    | "class" : if you use bensampo/laravel-enum package
    | "array" : otherwise
    |
    */
    'type' => 'array',

    /*
    |--------------------------------------------------------------------------
    | Status Value
    |--------------------------------------------------------------------------
    |
    | Fill this option if you choose to use "array" as status type. 
    | This option defines the structure for the all status value.
    |
    */
    'status' => [
        'default' => [
            'Active',
            'Inactive'
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Status Card Background Color
    |--------------------------------------------------------------------------
    |
    | This option defines the background color for the card. The structure is
    | the same as the value and you need to provide the color representation
    | value for each item. You can choose between using hex (e.g. '#D5D5D5'),
    | css rgb function (e.g. 'rgb(200,20,130)'), and a color name 
    | (e.g. 'whitesmoke').
    |
    */
    'background' => [
        'default' => [
            '#21b978',
            'rgb(231, 68, 68)'
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Status Card Text Color
    |--------------------------------------------------------------------------
    |
    | This option defines the text color for the card. The structure is
    | the same as the background value. You can choose between using hex 
    | (e.g. '#D5D5D5'), css rgb function (e.g. 'rgb(200,20,130)'), and a color
    | name (e.g. 'whitesmoke').
    |
    */
    'text' => [
        'default' => [
            'white',
            '#FFFFFF'
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Card Sizing
    |--------------------------------------------------------------------------
    |
    | This option defines all customizable sizing in the card component. It uses
    | tailwind css classes except for 'choices_size'.
    |
    */
    'sizes' => [
        'cards_size' => 'w-1/5',
        'title_size' => 'text-xl',
        'status_size' => 'text-2xl',
        'edit_field_size' => 'text-xl',
        'icon_width_size' => 'w-16',
        'choices_size' => '25px',
        'save_button_size' => 'text-xs'
    ]


];
