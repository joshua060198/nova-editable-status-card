# Editable Status Card

This package lets you add a status card on your resource detail page and you can directly edit the status on the card.

## Installation

```shell
composer require joshua060198/nova-editable-status-card
```

## Publishing config

```shell
php artisan vendor:publish --provider="Joshua060198/ToolServiceProvider"
```

## Config

### Type

Change this config to `class` if you want to use [bensampo/laravel-enum](https://github.com/BenSampo/laravel-enum) package.

```php

return [

    ...

    'type' => 'array',

    ...

]
```

### Status data

If you are not using [bensampo/laravel-enum](https://github.com/BenSampo/laravel-enum) package, you must provide all the possible status data in this config. You can divide each data using category name. For example, if you want to have different status for `Order` and `Payment`, you can use:

```php

return [

    ...

    'status' => [
        'order' => [
            'Not Approve',
            'Approve'
        ],
        'payment' => [
            'Not Paid',
            'Paid',
            'Waiting'
        ]
    ],

    ...

]
```

### Card background color

For every data, provide the card background color. The color can be defined using css color (name, rgb(), rgba(), or hexadecimal). Using the above example, you can use:

```php

return [

    ...

    'status' => [
        'order' => [
            '#ff0000', // full red
            'rgb(0, 255, 0)' // full green
        ],
        'payment' => [
            'red',
            'green',
            'whitesmoke'
        ]
    ],

    ...

]
```

### Card text color

Same with background color, you must provide the text color for each status data. For example, you can use:

```php

return [

    ...

    'status' => [
        'order' => [
            'white',
            '#fff'
        ],
        'payment' => [
            'gray',
            'rgb(129, 100, 30)',
            '#ababab'
        ]
    ],

    ...

]
```

### Size

This config defines the size of:

-   Cards
-   Title
-   Status text
-   Icon (use fix sizing: `px`, `rem`, `em`, `%`)
-   Edit field
-   Edit choices
-   Save button

You have to use `tailwind.css` classes for each options except for icon size.

```php

return [

    ...

    'sizes' => [
        'cards_size' => 'w-1/5',
        'title_size' => 'text-xl',
        'status_size' => 'text-2xl',
        'edit_field_size' => 'text-xl',
        'icon_width_size' => 'w-16',
        'choices_size' => '25px',
        'save_button_size' => 'text-xs'
    ]

    ...

]
```

## Usage

```php
// app/Nova/Order.php

use Joshua060198\EditableStatusCard\EditableStatusCard;

class Order extends Resource {

    ...

    public function fields(Request $request) {

        return [
            // data from array
            EditableStatusCard::make(
                'Order Status',
                'order_status_column',
                $this->order_status_column
            )
            ->dataFromArray('order'),

            // data from enum class
            EditableStatusCard::make(
                'Other Status',
                'my_other_status_colum',
                $this->getStatusValue()
            )
            ->dataFromClass('MyEnumClass')
            // with icon
            ->withIcon('https://icon.com/my-icon.png'),
        ]
    }

    ...
}
```

## Permission

If you want to restrict the editing capability, you can use `EditableStatusTrait` trait to your model and override `editableStatusPermission()` function.

```php

use Joshua060198\EditableStatusCard\EditableStatusTrait;

class Order extends Model {
    use EditableStatusTrait;

    ...

    public static function editableStatusPermission(NovaRequest $request)
    {
        return $request->user()->id === 1;
    }

    ...
}
```

## License

The [MIT](LICENSE) license.