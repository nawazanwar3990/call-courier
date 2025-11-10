<div class="row">
    <div class="col-12 mb-2">
        {{ html()->label(__('general.thumbnail_image'), 'picture')->class('form-label') }}
        {{ html()->file('picture')->id('picture')->class(['form-control dropify'])->attributes([
            'accept' => '.jpg, .jpeg, .png',
            'data-default-file'=>isset($for)?$model->getFirstMediaUrl('picture'):''
        ]) }}
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-2">
        {{ html()->label(__('general.mobile').'<i class="text-danger">*</i>', 'mobile')->class('form-label') }}
        {{ html()->text('mobile')->id('mobile')->class('form-control')->required() }}
    </div>
    <div class="col-md-6 mb-2">
        {{ html()->label(__('general.username').'<i class="text-danger">*</i>', 'username')->class('form-label') }}
        {{ html()->text('username')->id('username')->class('form-control')->required() }}
    </div>
    <div class="col-md-6 mb-2">
        {{ html()->label(__('general.email'), 'email')->class('form-label') }}
        {{ html()->email('email')->id('email')->class('form-control') }}
    </div>
    <div class="col-md-6 mb-2">
        {{ html()->label(__('general.password') . (!isset($for) ? ' <i class="text-danger">*</i>' : ''), 'password')->class('form-label') }}
        {{ html()->password('password')->id('password')->class('form-control')->attribute('autocomplete', 'new-password')->attributeIf(!isset($for), 'required') }}
    </div>
</div>

{{-- 🔽 Branch Dropdown --}}
<div class="row">
    <div class="col-md-6 mb-2">
        {{ html()->label(__('general.branch').'<i class="text-danger">*</i>', 'branch_id')->class('form-label') }}
        {{ html()->select('branch_id',\App\Services\GeneralService::pluckBranches() ?? [], isset($for) ? $model->branch_id : null)
            ->id('branch_id')
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
