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
            'icon_width_size' => 'w-8',
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
        $values = $class::getValues();
        $keys = $class::getKeys();

        for ($i = 0; $i < count($keys); $i++) {
            $data[$values[$i]] = preg_replace('/(?<!\ )[A-Z]/', ' $0', $keys[$i]);
        }
        $this->withMeta(['data' => $data]);

        return $this;
    }

    /**
     * Set status card current value.
     * 
     * @param Integer $value
     * @return this
     */
    public function value($value)
    {
        $this->withMeta(['value' => $value]);
        
        return $this;
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
        $this->withMeta(['icon' => $icon]);
        
        return $this;
    }

    /**
     * Set card spacing
     * 
     * @param Boolean $compact
     * @return this
     */
    public function compact($compact = true) {
        $this->withMeta(['compact' => $compact]);
        
        return $this;
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
                $this->withMeta(['can_edit' => call_user_func($callback)]);
                
                return $this;
            } else {
                $this->withMeta(['can_edit' => $callback]);
                
                return $this;
            }
    }

    /**
     * Set card size as class name
     * 
     * @param String $class
     * @return this
     */
    public function cardSize($class = '') {
        $this->withMeta(['card_size' => $class]);
        
        return $this;
    }

    /**
     * Set card title size as class name
     * 
     * @param String $class
     * @return this
     */
    public function titleSize($class = '') {
        $this->withMeta(['title_size' => $class]);
        
        return $this;
    }

    /**
     * Set card status size as class name
     * 
     * @param String $class
     * @return this
     */
    public function statusSize($class = '') {
        $this->withMeta(['status_size' => $class]);
        
        return $this;
    }

    /**
     * Set card edit field size as class name
     * 
     * @param String $class
     * @return this
     */
    public function editFieldSize($class = '') {
        $this->withMeta(['edit_field_size' => $class]);
        
        return $this;
    }

    /**
     * Set card icon width size size as class name
     * 
     * @param String $class
     * @return this
     */
    public function iconWidthSize($class = '') {
        $this->withMeta(['icon_width_size' => $class]);
        
        return $this;
    }

    /**
     * Set card choices size size as class name
     * 
     * @param String $class
     * @return this
     */
    public function choicesSize($class = '') {
        $this->withMeta(['choices_size' => $class]);
        
        return $this;
    }

    /**
     * Set card save button size as class name
     * 
     * @param String $class
     * @return this
     */
    public function saveButtonSize($class = '') {
        $this->withMeta(['save_button_size' => $class]);
        
        return $this;
    }
}
