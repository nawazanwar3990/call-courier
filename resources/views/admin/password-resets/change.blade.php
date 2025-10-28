<x-dashboard-layout :page-title="$pageTitle">
    <div class="row my-5 justify-content-center">
        <div class="col-12 col-sm-8 col-md-8 col-lg-3 col-xl-2 col-xxl-1">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $pageTitle }}</h4>
                </div>

                {{ html()->form('POST', route('admin.password.update', $model->id))->acceptsFiles()->id('popup_form')->open() }}

                <div class="card-body">
                    <div class="row justify-content-center">
                        {{-- New Password --}}
                        <div class="col-12 mb-3">
                            {{ html()->label(__('general.new_password'), 'new_password')->class('form-label') }}
                            <div class="input-group input-group-merge">
                                {{ html()->password('new_password')->id('new_password')->class('form-control')->required()->placeholder('••••••••••')->attributes(['aria-describedby' => 'password', 'autocomplete' => 'new-password']) }}
                                <button type="button" class="input-group-text" onclick="togglePassword('new_password', this)">
                                    <i class="ti ti-eye-off"></i>
                                </button>
                                <button class="btn btn-outline-secondary" type="button" id="generate-password" title="Generate Password">
                                    <i class="fa fa-key"></i>
                                </button>
                            </div>
                        </div>

                        {{-- Confirm Password --}}
                        <div class="col-12 mb-3">
                            {{ html()->label(__('general.confirm_password'), 'new_password_confirmation')->class('form-label') }}
                            <div class="input-group input-group-merge">
                                {{ html()->password('new_password_confirmation')->id('new_password_confirmation')->class('form-control')->required()->placeholder('••••••••••')->attributes(['aria-describedby' => 'password']) }}
                                <button type="button" class="input-group-text" onclick="togglePassword('new_password_confirmation', this)">
                                    <i class="ti ti-eye-off"></i>
                                </button>
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="col-12 mb-3">
                            <x-modal-buttons :save="true" :cancel="true"/>
                        </div>
                    </div>

                    <x-updated-by />
                </div>

                {{ html()->form()->close() }}
            </div>
        </div>
    </div>
</x-dashboard-layout>
