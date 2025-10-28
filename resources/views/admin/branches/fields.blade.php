<div class="row">
    <div class="col-12 mb-2">
        {{ html()->label(__('general.thumbnail_image'), 'thumbnail_image')->class('form-label') }}
        {{ html()->file('picture')->id('thumbnail_image')->class(['form-control dropify'])->attributes([
            'accept' => '.jpg, .jpeg, .png',
            'data-default-file'=>isset($for)?$model->getFirstMediaUrl('picture'):''
        ]) }}
    </div>
    <div class="col-12 mb-2">
        {{ html()->label(__('general.task_name'), 'task_name')->class('form-label') }}
        {{ html()->text('task_name')->id('task_name')->class('form-control')->required() }}
    </div>
</div>
<div class="row">
    <div class="col-12 mb-2">
        {{ html()->label(__('general.task_instruction'), 'task_instruction')->class('form-label') }}
        {{ html()->textarea('task_instruction')->id('task_instruction')->class('form-control tinymce')->required() }}
    </div>
    <div class="col-12 mb-2">
        {{ html()->label(__('general.task_url'), 'task_url')->class('form-label') }}
        {{ html()->text('task_url')->id('task_url')->class('form-control')->required() }}
    </div>
</div>
<div class="row">
    <div class="col-6 mb-2">
        {{ html()->label(__('general.set_coins'), 'set_coins')->class('form-label') }}
        {{ html()->number('set_coins')->id('set_coins')->class('form-control')->attributes(['min'=>1])->required() }}
    </div>
    <div class="col-6 mb-2">
        {{ html()->label(__('general.task_limit')." (Note:  0=Unlimited)", 'task_limit')->class('form-label') }}
        {{ html()->number('task_limit')->id('task_limit')->class('form-control')->attributes(['min'=>0])->required()->value(isset($for)?$model->task_limit:'0') }}
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
