<div class="modal-dialog">
    <div class="modal-content">
        {{ html()->form('POST', route('admin.types.store'))->acceptsFiles()->id('popup_form')->open() }}
        <div class="modal-header">
            <h4 class="modal-title" id="ModalLabel">{{ $pageTitle }}</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
        </div>
        <div class="modal-body">
            <x-created-by></x-created-by>
            @include('admin.type.fields')
        </div>
        <div class="modal-footer">
            <x-modal-buttons :save="true" :cancel="true" />
        </div>
        {{ html()->form()->close() }}
    </div>
</div>
