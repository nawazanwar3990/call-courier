<x-dashboard-layout :page-title="$pageTitle">
    <x-breadcrumb :page-title="$pageTitle" :bread-crumbs="$breadCrumbs" />

    <div class="row mb-2">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item"><strong class="text-primary">{{ __('general.view') }}</strong>
                            {{ __('general.for_viewing_record') }}
                        </li>
                        <li class="list-group-item"><strong class="text-primary">{{ __('general.list') }}</strong>
                            {{ __('general.for_navigation') }}
                        </li>
                        <li class="list-group-item"><strong class="text-primary">{{ __('general.create') }}</strong>
                            {{ __('general.for_creating_record') }}
                        </li>
                        <li class="list-group-item"><strong class="text-primary">{{ __('general.update') }}</strong>
                            {{ __('general.for_editing_record') }}
                        </li>
                        <li class="list-group-item"><strong class="text-primary">{{ __('general.delete') }}</strong>
                            {{ __( 'general.for_deleting_record') }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            {{ html()->form('POST', route('admin.role-permissions.store', ['role'=>request()->query('role')]))->acceptsFiles()->id('role_permissions_form')->open() }}
            <div class="card border-primary my-3">
                <div class="card-body parent-card">
                    <div class="row">
                        @foreach($permissions as $permission)
                            <div class="col-3 my-2">
                                <input type="checkbox" name="permissions[]"
                                       id="check_{{ $permission->id }}"
                                       class="{{$permission->id}}_checkbox inner_check_box form-check-input"
                                       @if($rolePermissions->where('permission_id', $permission->id)->first()) checked @endif
                                       value="{{ $permission->id }}">
                                <label for="check_{{ $permission->id }}" class="form-check-label">
                                    {{ $permission->label }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <x-buttons :save="true" :cancel="true" :reset="true"
                       :cancel-route="route('admin.roles.index')" />
            {{ html()->form()->close() }}
        </div>
    </div>

    <x-slot:pageJs>
        <script>
            $(function () {
                $('#role_permissions_form').parsley();
            });

            $('#role_permissions_form').submit(function(e) {
                e.preventDefault();

                let form = $(this);
                let data = new FormData(this);

                showWait();
                $.ajax({
                    method: 'POST',
                    url: form.attr('action'),
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: data,
                    success: function (result) {
                        hideWait();
                        if (result.success === true) {
                            showAlert(result.msg, 'success');

                            location.assign('{{ route('admin.roles.index') }}');

                        } else {
                            showAlert(result.msg, 'error');
                        }
                    },
                    error: function (request, error, thrownError) {
                        hideWait();
                        if (request.status === 422) {
                            showValidationErrors(request);
                        } else {
                            showAlert(request.status + ': ' + error, 'error');
                        }
                    },
                });
            });
        </script>
    </x-slot:pageJs>
</x-dashboard-layout>
