@props([
    'save' => false,
    'savePrint' => false,
    'update' => false,
    'updatePrint' => false,
    'cancel' => false,
    'formId' => '',
    'lastModifiedModel' => null,
])
<div @class(['d-flex', 'w-100', 'mt-3', 'ms-0', 'justify-content-end' => is_null($lastModifiedModel), 'justify-content-between' => !is_null($lastModifiedModel)])>
    @if(!is_null($lastModifiedModel))
        <div>
            <small class="text-muted">
                {{ __('general.last_modified_by') }}: {{ $lastModifiedModel->updatedBy?->username }}
                <br>
                {{ __('general.last_modified_at') }}: {{ \Carbon\Carbon::parse($lastModifiedModel->updated_at)->timezone(config('app.timezone'))->format('d-M-Y h:i:s A') }}
            </small>
        </div>
    @endif
    <div class="btn-group" role="group">
        @if ($savePrint)
            <button type="button" class="btn btn-outline-info waves-effect" id="btn_save_print" onclick="SubmitAndPrint('{{ $formId }}');">
                <i class="far fa-print fa-lg"></i><span class="d-none d-md-block ms-2">{{ __('general.save_print') }}</span>
            </button>
            {{ html()->hidden('doPrint', 0)->id('doPrint') }}
        @endif
        @if ($updatePrint)
            <button type="button" class="btn btn-outline-info waves-effect" id="btn_save_print" onclick="SubmitAndPrint('{{ $formId }}');">
                <i class="far fa-print-magnifying-glass fa-lg"></i><span class="d-none d-md-block ms-2">{{ __('general.update_print') }}</span>
            </button>
            {{ html()->hidden('doPrint', 0)->id('doPrint') }}
        @endif
        @if ($save)
            <button type="submit" class="btn btn-outline-success waves-effect" id="btn_save">
                <i class="fa-regular fa-save fa-lg"></i><span class="d-none d-md-block ms-2">{{ __('general.save') }}</span>
            </button>
        @endif
        @if ($update)
            <button type="submit" class="btn btn-outline-success waves-effect" id="btn_save">
                <i class="fa-regular fa-arrows-rotate fa-lg"></i><span class="d-none d-md-block ms-2">{{ __('general.update') }}</span>
            </button>
        @endif
        @if ($cancel)
            <button type="button" class="btn btn-outline-danger waves-effect" data-bs-dismiss="modal">
                <i class="fa-regular fa-xmark fa-lg"></i><span class="d-none d-md-block ms-2">{{ __('general.cancel') }}</span>
            </button>
        @endif
    </div>
</div>
