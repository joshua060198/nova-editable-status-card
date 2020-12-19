<?php

namespace Joshua060198\EditableStatusCard;

use Closure;
use Illuminate\Support\Str;
use Laravel\Nova\ResourceTool;

class EditableStatusCard extends ResourceTool
{
    /**
     * Constructor.
     * 
     * @param \BenSampo\Enum\Enum $class
     * @param Integer $value
     * @param String $title
     * @param String $attribute
     * @return void
     */
    public function __construct($class, $value, $title = 'Status', $attribute = null)
    {
        parent::__construct();

        $this->withMeta([
            'title' => $title,
            'attribute' => $attribute ?? str_replace(' ', '_', Str::lower($title)),
            'background_color' => ['#21b978', 'rgb(231, 68, 68)'],
            'text_color' => ['white', '#FFFFFF'],
            'value' => $value,
            'icon' => null,
            'compact' => false,
            'can_edit' => true,
            'card_size' => 'w-1/5',
            'title_size' => 'text-sm',
            'status_size' => 'text-base',
            'edit_field_size' => 'text-xs',
            'icon_size' => 'w-8',
            'choices_size' => '25px',
            'save_button_size' => 'text-xs',
        ]);

        $this->dataFromClass($class);
    }

    /**
     * Get the displayable name of the resource tool.
     *
     * @return string
     */
    public function name()
    {
        return 'Editable Status Card';
    }

    /**
     * Get the component name for the resource tool.
     *
     * @return string
     */
    public function component()
    {
        return 'editable-status-card';
    }

    /**
     * Set status data from enum class.
     * 
     * @param \BenSampo\Enum\Enum $class
     * @return this
     */
    public function dataFromClass($class)
    {
        $this->withMeta(['background_color' => $class::editableStatusBackgroundColor()]);

        $this->withMeta(['text_color' => $class::editableStatusTextColor()]);

        $data = [];
        foreach ($class::asArray() as $key => $value) {
            array_push($data, preg_replace('/(?<!\ )[A-Z]/', ' $0', $key));
        }
        return $this->withMeta(['data' => $data]);
    }

    /**
     * Set status card current value.
     * 
     * @param Integer $value
     * @return this
     */
    public function value($value)
    {
        return $this->withMeta(['value' => $value]);
    }

    /**
     * Set status card icon. It can be a fullpath to the icon file or
     * any url to the source.
     * 
     * @param String $icon
     * @return this
     */
    public function withIcon($icon)
    {
        return $this->withMeta(['icon' => $icon]);
    }

    /**
     * Set card spacing
     * 
     * @param Boolean $compact
     * @return this
     */
    public function compact($compact = true) {
        return $this->withMeta(['compact' => $compact]);
    }

    /**
     * Set editing feature on card
     * 
     * @param Boolean $callback
     * @return this
     */
    public function canEdit($callback = true) {
        if ((is_string($callback) && function_exists($callback))  
            || (is_object($callback) && ($callback instanceof Closure))) {
                return $this->withMeta(['can_edit' => call_user_func($callback)]);
            } else {
                return $this->withMeta(['can_edit' => $callback]);
            }
    }

    /**
     * Set card size as class name
     * 
     * @param String $class
     * @return this
     */
    public function cardSize($class = '') {
        return $this->withMeta(['card_size' => $class]);
    }

    /**
     * Set card title size as class name
     * 
     * @param String $class
     * @return this
     */
    public function titleSize($class = '') {
        return $this->withMeta(['title_size' => $class]);
    }

    /**
     * Set card status size as class name
     * 
     * @param String $class
     * @return this
     */
    public function statusSize($class = '') {
        return $this->withMeta(['status_size' => $class]);
    }

    /**
     * Set card edit field size as class name
     * 
     * @param String $class
     * @return this
     */
    public function editFieldSize($class = '') {
        return $this->withMeta(['edit_field_size' => $class]);
    }

    /**
     * Set card icon width size size as class name
     * 
     * @param String $class
     * @return this
     */
    public function iconSize($class = '') {
        return $this->withMeta(['icon_size' => $class]);
    }

    /**
     * Set card choices size
     * 
     * @param String $size
     * @return this
     */
    public function choicesSize($size = '') {
        return $this->withMeta(['choices_size' => $size]);
    }

    /**
     * Set card save button size as class name
     * 
     * @param String $class
     * @return this
     */
    public function saveButtonSize($class = '') {
        return $this->withMeta(['save_button_size' => $class]);
    }
}
