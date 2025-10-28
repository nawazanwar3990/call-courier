<div class="row">
    <div class="col-12 mb-2">
        {{ html()->label(__('general.image_uploaded'), 'picture')->class('form-label') }}
        {{ html()->file('picture')->id('picture')->class(['form-control dropify'])->attributes([
            'accept' => '.jpg, .jpeg, .png',
            'data-default-file'=>isset($for)?$model->getFirstMediaUrl('picture'):''
        ]) }}
    </div>
    <div class="col-md-6 mb-2">
        {{ html()->label(__('general.gift_card_title'), 'name')->class('form-label') }}
        {{ html()->text('name')->id('name')->class('form-control')->required() }}
    </div>
    <div class="col-md-6 mb-2">
        {{ html()->label(__('general.gift_card_type'), 'type')->class('form-label') }}
        {{ html()->select('type_id',\App\Services\GeneralService::getTypeDropdown())->id('type_id')->class(['form-control', 'select2'])->required()->style('width: 100%') }}
    </div>
    <div class="col-12 mb-2">
        {{ html()->label(__('general.point_cost'), 'point_cost')->class('form-label') }}
        <div class="input-group">
            <span class="input-group-text">$</span>
            {{ html()->number('point_cost')->id('point_cost')->class('form-control')->required() }}
        </div>
    </div>
    <div class="col-6 mb-2">
        {{ html()->label(__('general.description'), 'description')->class('form-label') }}
        {{ html()->textarea('description')->id('description')->class('form-control') }}
    </div>
    <div class="col-6 mb-2">
        {{ html()->label(__('general.terms'), 'terms')->class('form-label') }}
        {{ html()->textarea('terms')->id('terms')->class('form-control') }}
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
