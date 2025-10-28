<x-website-layout :page-title="$pageTitle">
    <div class="container home-page-holder">
        <div class="row justify-content-center home-profile-holder">
            <div class="col-md-7">
                <div class="card mb-4 p-4">
                    <div
                        class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                        <div class="flex-shrink-0 mx-sm-0 mx-auto">
                            <img
                                src="{{ $user->getFirstMediaUrl('picture') }}"
                                alt="user image"
                                class="d-block rounded-circle user-profile-img shadow"
                                style="width: 120px; height: 120px; object-fit: cover;"/>
                        </div>
                        <div class="flex-grow-1 mt-3 mt-sm-0 ps-sm-4">
                            <div
                                class="d-flex align-items-center justify-content-between flex-column flex-md-row gap-3">
                                <div class="user-profile-info text-center text-sm-start mt-3">
                                    <h3 class="mb-1">
                                        {{ $user->username }}
                                    </h3>
                                    <ul class="list-inline mb-2 text-muted small d-flex flex-wrap gap-3 justify-content-center justify-content-sm-start">
                                        <li class="list-inline-item d-flex align-items-center gap-1">
                                            <i class="ti ti-calendar"></i> {{ trans('general.joined') }} {{ $user->created_at->format('F Y') }}
                                        </li>
                                    </ul>
                                    <span class="badge rounded-pill bg-label-success">Active</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <h5 class="card-header">{{ __('general.profile') }}</h5>
                                <div class="card-body">
                                    {{ html()->form('POST', route('website.user.profile.update'))->acceptsFiles()->class('profile_form')->open() }}
                                    {{ html()->hidden('type', 'profile')->id('type_profile') }}
                                    @csrf
                                    <div class="row">
                                        <div class="col-12 mb-2">
                                            {{ html()->label(__('general.email'), 'email')->class('form-label') }}
                                            {{ html()->text('email', auth()->user()->email)->id('email')->class(['form-control', 'bg-disabled'])->isReadonly()->attribute('tabindex', '-1') }}
                                        </div>
                                        <div class="col-12 mb-2">
                                            {{ html()->label(__('general.username'), 'username')->class('form-label') }}
                                            {{ html()->text('username', auth()->user()->username)->id('username')->class(['form-control'])->required() }}
                                        </div>
                                        <div class="col-12 mb-2">
                                            {{ html()->label(__('general.profile_picture'), 'profile_picture')->class('form-label') }}
                                            {{ html()->file('profile_picture')->id('profile_picture')->class(['form-control'])->accept('.jpg, .jpeg, .png') }}
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <div class="form-check">
                                            <input class="form-check-input"
                                                   value="1"
                                                   type="checkbox"
                                                   id="privacy_policy"
                                                   name="privacy_policy"
                                                {{ auth()->user()->privacy_policy ? 'checked' : '' }} />

                                            <label class="form-check-label" for="privacy-policy">
                                                {{ __('general.i_agree') }}&nbsp;
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#policyModal"
                                                   onclick="showPolicyTab('terms')">
                                                    <span>{{ __('general.terms_conditions') }}</span>
                                                </a>&nbsp;
                                                {{ __('general.and') }}&nbsp;
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#policyModal"
                                                   onclick="showPolicyTab('privacy')">
                                                    <span>{{ __('general.privacy_policy') }}.</span>
                                                </a>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-12 text-end">
                                            <button type="submit"
                                                    class="btn btn-outline-success waves-effect">
                                                <i class="ti ti-device-floppy ti-md me-2"></i>{{ __('general.save') }}
                                            </button>
                                        </div>
                                    </div>
                                    {{ html()->form()->close() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card p-4 mb-4">
                    <h5 class="mb-4">Update Password</h5>
                    {{ html()->form('POST', route('website.user.profile.update'))->acceptsFiles()->class('profile_form')->open() }}
                    {{ html()->hidden('type', 'password')->id('type_password') }}
                    <div class="row">
                        <div class="col-12 mb-2 form-password-toggle">
                            {{ html()->label(__('general.old_password'), 'old_password')->class('form-label') }}
                            <div class="input-group input-group-merge">
                                {{ html()->password('old_password')->id('old_password')->class(['form-control'])->required()->placeholder('&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;')->attributes(['aria-describedby' => 'password']) }}
                                <span class="input-group-text cursor-pointer"><i
                                        class="ti ti-eye-off"></i></span>
                            </div>
                        </div>
                        <div class="col-12 mb-2 form-password-toggle">
                            {{ html()->label(__('general.new_password'), 'new_password')->class('form-label') }}
                            <div class="input-group input-group-merge">
                                {{ html()->password('new_password')->id('new_password')->class(['form-control'])->required()->placeholder('&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;')->attributes(['aria-describedby' => 'password']) }}
                                <span type="button" class="input-group-text"
                                      onclick="togglePassword('new_password', this)">
                                                    <i class="ti ti-eye-off"></i>
                                            </span>
                            </div>
                        </div>
                        <div class="col-12 mb-2 form-password-toggle">
                            {{ html()->label(__('general.confirm_password'), 'new_password_confirmation')->class('form-label') }}
                            <div class="input-group input-group-merge">
                                {{ html()->password('new_password_confirmation')->id('new_password_confirmation')->class(['form-control'])->required()->placeholder('&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;')->attributes(['aria-describedby' => 'password']) }}
                                <span type="button" class="input-group-text"
                                      onclick="togglePassword('new_password_confirmation', this)">
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
                <div class="delete-profile-holder">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#policyModal"
                       onclick="showPolicyTab('privacy')" class="btn btn-outline-primary w-100 mb-3">
                        <i class="ti ti-lock"></i><span class="mt-1">{{ __('general.privacy_policy') }}</span>
                    </a>
                    <a onclick="deletePermanentAccount('{{ auth()->id() }}');"
                       class="btn btn-outline-primary w-100 mb-3">
                        <i class="ti ti-trash"></i> <span class="mt-1">{{ __('general.delete_account') }}</span>
                    </a>
                </div>

            </div>
        </div>
    </div>
    @include('website.term-conditions')
</x-website-layout>
