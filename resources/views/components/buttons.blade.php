@props([
    'save' => false,
    'savePrint' => false,
    'saveNew' => false,
    'update' => false,
    'updatePrint' => false,
    'cancel' => false,
    'reset' => false,
    'cancelRoute' => '',
    'formId' => '',
    'lastModifiedModel' => null,
])
<div class="row mt-4">
    @if(!is_null($lastModifiedModel))
    <div class="col-md-6 align-middle">
        <small class="text-muted">
            {{ __('general.last_modified_by') }}: {{ $lastModifiedModel->updatedBy?->username }}&nbsp;&nbsp;&nbsp;
            {{ __('general.last_modified_at') }}: {{ \Carbon\Carbon::parse($lastModifiedModel->updated_at)->timezone(config('app.timezone'))->format('d-M-Y h:i:s A') }}
        </small>
    </div>
    @endif
    <div @class(['text-end', 'col-12' => is_null($lastModifiedModel), 'col-md-6' => !is_null($lastModifiedModel)])>
        <div class="btn-group" role="group">
            @if ($savePrint)
                <button type="button" class="btn btn-outline-info waves-effect" id="btn_save_print" onclick="SubmitAndPrint('{{ $formId }}');">
                    <i class="far fa-print fa-lg"></i><span class="d-none d-md-block">&nbsp;{{ __('general.save_print') }}</span>
                </button>
                {{ html()->hidden('doPrint', 0)->id('doPrint') }}
            @endif
            @if ($updatePrint)
                <button type="button" class="btn btn-outline-info waves-effect" id="btn_save_print" onclick="SubmitAndPrint('{{ $formId }}');">
                    <i class="far fa-print-magnifying-glass fa-lg"></i><span class="d-none d-md-block">&nbsp;{{ __('general.update_print') }}</span>
                </button>
                {{ html()->hidden('doPrint', 0)->id('doPrint') }}
            @endif
            @if ($saveNew)
                <button type="button" class="btn btn-outline-primary waves-effect" id="btn_save_new" onclick="SubmitAndNew('{{ $formId }}');">
                    <i class="fa-regular fa-floppy-disk-circle-arrow-right fa-lg"></i><span class="d-none d-md-block">&nbsp;{{ __('general.save_new') }}</span>
                </button>
                {{ html()->hidden('saveNew', 0)->id('saveNew') }}
            @endif
            @if ($save)
                <button type="submit" class="btn btn-outline-success waves-effect" id="btn_save">
                    <i class="fa-regular fa-save fa-lg"></i><span class="d-none d-md-block">&nbsp;{{ __('general.save') }}</span>
                </button>
            @endif
            @if ($update)
                <button type="submit" class="btn btn-outline-success waves-effect" id="btn_save">
                    <i class="fa-regular fa-arrows-rotate fa-lg"></i><span class="d-none d-md-block">&nbsp;{{ __('general.update') }}</span>
                </button>
            @endif
            @if ($reset)
                <a href="javascript:void(0);" onclick="askForReset('{{ request()->fullUrl() }}')" class="btn btn-outline-warning waves-effect" id="btn_reset">
                    <i class="fa-regular fa-arrow-rotate-left fa-lg"></i><span class="d-none d-md-block">&nbsp;{{ __('general.reset') }}</span>
                </a>
            @endif
            @if ($cancel)
                <a class="btn btn-outline-danger waves-effect"  href="{{ $cancelRoute }}" id="btn_cancel">
                    <i class="fa-regular fa-xmark fa-lg"></i><span class="d-none d-md-block">&nbsp;{{ __('general.cancel') }}</span>
                </a>
            @endif
        </div>
    </div>
</div>
