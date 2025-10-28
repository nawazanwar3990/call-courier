@props([
    'required' => false,
    'label' => '',
])
<label {!! $attributes->merge(['class' => 'form-label']) !!}>{!! $label !!} {!! $required ? '<span class="text-danger">*</span>' : '' !!}</label>
