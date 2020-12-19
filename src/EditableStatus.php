<?php

namespace Joshua060198\EditableStatusCard;

trait EditableStatus
{
    public static function getMappedBackgroundColor() {
        return [];
    }

    public static function getMappedTextColor() {
        return [];
    }

    public static function editableStatusBackgroundColor() {
        return static::editableStatusColor(static::getMappedBackgroundColor());
    }
    
    public static function editableStatusTextColor() {
        return static::editableStatusColor(static::getMappedTextColor());
    }

    public static function editableStatusColor($data) {
        $result = [];

        foreach ($data as $key => $value) {
            $result[static::getValue($key)] = $value;
        }

        return $result;
    }
}
