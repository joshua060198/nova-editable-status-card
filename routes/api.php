<?php

use Illuminate\Support\Facades\Route;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Nova;

Route::post('allowediting', function (NovaRequest $request) {
    $resource_name = $request->input('resourceName');
    $resources = collect(Nova::$resources);
    $model = $resources->filter(function ($resource) use ($resource_name) {
        return $resource::uriKey() == $resource_name;
    })->map(function ($resource) {
        return $resource::$model;
    });

    $result = false;

    foreach ($model as $key => $value) {
        $result = $value::editableStatusPermission($request);
    }
    return response()->json(['result' => $result]);
});

Route::post('sizes', function (NovaRequest $request) {
    $result = config('editable-status-card.sizes');
    return response()->json(['result' => $result]);
});

Route::get('checkdebug', function(NovaRequest $request) {
    $result = config('app.debug');
    return response()->json(['debug' => $result]);
});

Route::post('save', function (NovaRequest $request) {
    $resource_name = $request->input('resourceName');
    $resource_id = $request->input('resourceId');
    $attribute = $request->input('attribute');
    $newValue = $request->input('value');

    $resources = collect(Nova::$resources);
    $model = $resources->filter(function ($resource) use ($resource_name) {
        return $resource::uriKey() == $resource_name;
    })->map(function ($resource) {
        return $resource::$model;
    });

    $result = false;

    $model_obj = null;

    foreach ($model as $key => $value) {
        $model_obj = $value;
        $result = $value::editableStatusPermission($request);
    }

    if (!$result) {
        return response()->json(['error' => 'You are not authorized to perform this!']);
    } else {
        $data = $model_obj::find($resource_id);
        $data->$attribute = $newValue;
        $data->save();
        return response()->json(['data' => 'Succesfully update ' . $value . '::' . $attribute . '!']);
    }
});
