@props([
    'model' => null,
])
{{ html()->hidden('model_id', $model->id)->id('model_id') }}
