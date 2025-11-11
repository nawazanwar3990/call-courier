<x-dashboard-layout :page-title="$pageTitle" :small-container="true">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="user-profile-header-banner">
                    <img src="{{ asset('assets/img/pages/profile-banner.png') }}" alt="Banner image" class="rounded-top" />
                </div>
                <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                    <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                        <img src="{{ auth()->user()->getFirstMediaUrl('picture') }}" alt="user image" class="d-block h-auto ms-0 ms-sm-4 rounded user-profile-img" width="100" />
                    </div>
                    <div class="flex-grow-1 mt-3 mt-sm-5">
                        <div class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                            <div class="user-profile-info">
                                <h4>{{ auth()->user()->username }}</h4>
                                <ul class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                    <li class="list-inline-item d-flex gap-1">
                                        <i class="ti ti-calendar"></i> {{ trans('general.joined') }} {{ \Carbon\Carbon::parse(auth()->user()->created_at)->format('F Y') }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <h5 class="card-header">{{ __('general.profile') }}</h5>
                <div class="card-body">
                    {{ html()->form('POST', route('admin.profile.store'))->acceptsFiles()->class('profile_form')->open() }}
                    {{ html()->hidden('type', 'profile')->id('type_profile') }}
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            {{ html()->label(__('general.username'), 'username')->class('form-label') }}
                            {{ html()->text('username', auth()->user()->username)->id('username')->class(['form-control', 'bg-disabled'])->isReadonly()->attribute('tabindex', '-1') }}
                        </div>
                        <div class="col-md-3 mb-2">
                            {{ html()->label(__('general.email'), 'email')->class('form-label') }}
                            {{ html()->text('email', auth()->user()->email)->id('email')->class(['form-control', 'bg-disabled'])->isReadonly()->attribute('tabindex', '-1') }}
                        </div>
                        <div class="col-12 mb-2">
                            {{ html()->label(__('general.profile_picture'), 'profile_picture')->class('form-label') }}
                            {{ html()->file('profile_picture')->id('profile_picture')->class(['form-control'])->accept('.jpg, .jpeg, .png') }}
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-outline-success waves-effect">
                                <i class="ti ti-device-floppy ti-md me-2"></i>{{ __('general.save') }}
                            </button>
                        </div>
                    </div>
                    {{ html()->form()->close() }}
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <h5 class="card-header">{{ __('general.password') }}</h5>
                <div class="card-body">
                    {{ html()->form('POST', route('admin.profile.store'))->acceptsFiles()->class('profile_form')->open() }}
                    {{ html()->hidden('type', 'password')->id('type_password') }}

                    <div class="row">
                        <div class="col-md-3 mb-2 form-password-toggle">
                            {{ html()->label(__('general.old_password'), 'old_password')->class('form-label') }}
                            <div class="input-group input-group-merge">
                                {{ html()->password('old_password')->id('old_password')->class(['form-control'])->required()->placeholder('&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;')->attributes(['aria-describedby' => 'password']) }}
                                <span type="button" class="input-group-text" onclick="togglePassword('old_password', this)">
                                   <i class="ti ti-eye-off"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3 mb-2 form-password-toggle">
                            {{ html()->label(__('general.new_password'), 'new_password')->class('form-label') }}
                            <div class="input-group input-group-merge">
                                {{ html()->password('new_password')->id('new_password')->class(['form-control'])->required()->placeholder('&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;')->attributes(['aria-describedby' => 'password']) }}
                                <span type="button" class="input-group-text" onclick="togglePassword('new_password', this)">
                                   <i class="ti ti-eye-off"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3 mb-2 form-password-toggle">
                            {{ html()->label(__('general.confirm_password'), 'new_password_confirmation')->class('form-label') }}
                            <div class="input-group input-group-merge">
                                {{ html()->password('new_password_confirmation')->id('new_password_confirmation')->class(['form-control'])->required()->placeholder('&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;')->attributes(['aria-describedby' => 'password']) }}
                                <span type="button" class="input-group-text" onclick="togglePassword('new_password_confirmation', this)">
                                   <i class="ti ti-eye-off"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-outline-success waves-effect">
                                <i class="ti ti-device-floppy ti-md me-2"></i>{{ __('general.save') }}
                            </button>
                        </div>
                    </div>
                    {{ html()->form()->close() }}
                </div>
            </div>
        </div>
    </div>
    <x-slot:pageJs>
        <script>
            $(function() {
                $('.select2').select2();
            });
        </script>
    </x-slot:pageJs>
</x-dashboard-layout>
