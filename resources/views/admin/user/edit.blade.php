<div class="modal-dialog modal-lg">
    <div class="modal-content">
        {{ html()->modelForm($model, 'PUT', route('admin.users.update', $model))->acceptsFiles()->id('popup_form')->open() }}
        <x-model-id :model="$model"/>

        <div class="modal-header">
            <h4 class="modal-title" id="ModalLabel">{{ $pageTitle }}</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
        </div>
        <div class="modal-body">
            <x-updated-by></x-updated-by>
            @include('admin.user.fields', ['for' => 'edit'])
        </div>

        <div class="modal-footer">
            <x-modal-buttons :update="true" :cancel="true" :last-modified-model="$model"/>
        </div>
        {{ html()->closeModelForm() }}
    </div>
</div>
