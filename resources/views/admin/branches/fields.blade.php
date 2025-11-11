
<div class="row">
    <div class="col-12 mb-2">
        {{ html()->label(__('general.name'), 'name')->class('form-label') }}
        {{ html()->text('name')->id('name')->class('form-control')->required() }}
    </div>
    <div class="col-12 mb-2">
        <label class="switch switch-square">
            {{ html()->checkbox('active', isset($for) ? $model->active : true)->id('active')->class('switch-input') }}
            <span class="switch-toggle-slider">
                <span class="switch-on"></span>
                <span class="switch-off"></span>
            </span>
            <span class="switch-label">{{ __('general.active') }}</span>
        </label>
    </div>
</div>
