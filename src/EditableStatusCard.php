<?php

namespace Joshua060198\EditableStatusCard;

use App\Enums\OrderDetailStatus;
use Closure;
use Illuminate\Support\Str;
use Laravel\Nova\ResourceTool;

class EditableStatusCard extends ResourceTool
{
    /**
     * Constructor.
     * 
     * @param String $title
     * @param String $attribute
     * @param Integer $value
     * @return void
     */
    public function __construct($title = 'Status', $attribute = null, $value = 0)
    {
        parent::__construct();

        $this->withMeta([
            'title' => $title,
            'attribute' => $attribute ?? str_replace(' ', '_', Str::lower($title)),
            'data' => config('editable-status-card.status.default'),
            'background_color' => config('editable-status-card.background.default'),
            'text_color' => config('editable-status-card.text.default'),
            'value' => $value,
            'icon' => null,
            'compact' => false
        ]);
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
     * @param BenSampo\Enum $class
     * @return this
     */
    public function dataFromClass($class, $category)
    {
        $this->withBackgroundColor($category);
        $this->withTextColor($category);
        $data = [];
        foreach ($class::asArray() as $key => $value) {
            array_push($data, preg_replace('/(?<!\ )[A-Z]/', ' $0', $key));
        }
        return $this->withMeta(['data' => $data]);
    }

    /**
     * Set status data from array in config files.
     * 
     * @param String $category
     * @return this
     */
    public function dataFromArray($category)
    {
        $this->withBackgroundColor($category);
        $this->withTextColor($category);
        return $this->withMeta(['data' => config('editable-status-card.status.' . $category)]);
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
     * Set card background color.
     * 
     * @param String $category
     * @return this
     */
    public function withBackgroundColor($category = 'default')
    {
        return $this->withMeta(['background_color' => config('editable-status-card.background.' . $category)]);
    }

    /**
     * Set card text color.
     * 
     * @param String $category
     * @return this
     */
    public function withTextColor($category = 'default')
    {
        return $this->withMeta(['text_color' => config('editable-status-card.text.' . $category)]);
    }

    public function compact() {
        return $this->withMeta(['compact' => true]);
    }
}
