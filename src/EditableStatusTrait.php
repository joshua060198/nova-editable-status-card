<?php

namespace Joshua060198\EditableStatusCard;

use Laravel\Nova\Http\Requests\NovaRequest;

trait EditableStatusTrait
{
    /**
     * Get the permission to edit the status directly from detail page
     * 
     * @param NovaRequest $request
     * @return Boolean
     */
    public static function editableStatusPermission(NovaRequest $request)
    {
        return true;
    }
}
