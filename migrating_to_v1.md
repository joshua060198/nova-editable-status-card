## Fully dependent on laravel-enum

From version 1.0.0 above, all status data will be provided via laravel enum class. If you have your data provided in array, try to install [laravel-enum](https://github.com/BenSampo/laravel-enum) package and use that package instead. **This may required additional changes on your resource fields implementation.**

## Move sizing utilities

In the previous version, this package use api to fetch all sizing utilitites which is stored on its own config file. Obviously, it will make additional HTTP request to the server which is not very efficient in my opinion. Another disadventage is that the sizing will be applied to all cards and make this package lack of customization. So, from version 1.0.0 above, the sizing utilities will be available for each individual card using these methods (see [docs](README.md) for more information):

- cardSize()
- titleSize()
- statusSize()
- editFieldSize()
- iconWidthSize()
- choicesSize()
- saveButtonSize()

## Permission for each individual cards

Version 1.0.0 introduce a new method to control each cards editing capability. It will be useful when your app has multiple roles and permissions and you want to make separate editing capability for different cards in the same resource. So, remove `EditableStatusTrait` from your model, and implement editing capability in each fields instead.

## Remove unused config file

**Make sure you have follow all the previous step.** FInally, remove `editable-status-card.php` from your `/config` folder.
