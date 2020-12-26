<?php

use Illuminate\Support\Facades\Route;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Nova;

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

    $model_obj = null;

    foreach ($model as $key => $value) {
        $model_obj = $value;
    }

    $data = $model_obj::find($resource_id);
    $data->$attribute = $newValue;
    $data->save();
    return response()->json(['data' => 'Succesfully update ' . $value . '::' . $attribute . '!']);
});
