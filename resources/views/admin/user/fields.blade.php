<div class="row">
    <div class="col-md-6 mb-2">
        {{ html()->label(__('general.username').'<i class="text-danger">*</i>', 'username')->class('form-label') }}
        {{ html()->text('username')->id('username')->class('form-control')->required() }}
    </div>
    <div class="col-md-6 mb-2">
        {{ html()->label(__('general.password') . (!isset($for) ? ' <i class="text-danger">*</i>' : ''), 'password')->class('form-label') }}
        {{ html()->text('password')
            ->id('password')
            ->class('form-control')
            ->attribute('autocomplete', 'new-password')
            ->attributeIf(!isset($for), 'required')
            ->value(isset($model) ? $model->normal_password : '') }}
    </div>
    <div class="col-md-6 mb-2">
        {{ html()->label(__('general.branch').'<i class="text-danger">*</i>', 'branch_id')->class('form-label') }}
        {{ html()->select('branch_id',\App\Services\GeneralService::pluckBranches() ?? [], isset($for) ? $model->branch_id : null)
            ->id('branch_id')
            ->placeholder('Select Branch')
            ->class('form-select')
            ->required() }}
    </div>
</div>
<div class="row">
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
