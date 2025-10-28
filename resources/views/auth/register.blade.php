<x-auth-layout :page-title="$pageTitle">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="py-4">
            <div class="card shadow mx-3">
                <div class="card-body">
                    @include('auth.logo', ['type' => 'register'])
                    <form method="POST" action="{{ route('register') }}" class="mb-3">
                        @csrf
                        <div class="row">
                            <div class="col-12 mb-2">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" name="username" id="username" class="form-control" value="{{ old('username') }}" />
                                @error('username') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-12 mb-2">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" />
                                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-12 mb-2">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" autocomplete="new-password" />
                                    <span class="input-group-text" onclick="togglePassword('password', this)">
                                        <i class="ti ti-eye-off"></i>
                                    </span>
                                </div>
                                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-12 mb-2">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="••••••••" autocomplete="new-password" />
                                    <span class="input-group-text" onclick="togglePassword('password_confirmation', this)">
                                    <i class="ti ti-eye-off"></i>
                                </span>
                                </div>
                                @error('password_confirmation') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="privacy_policy" name="privacy_policy" {{ old('privacy_policy') ? 'checked' : '' }} />
                                <label class="form-check-label" for="privacy_policy">
                                    {{ __('general.i_agree') }}&nbsp;
                                    <a data-bs-toggle="modal" data-bs-target="#policyModal" onclick="showPolicyTab('terms')">
                                        <span style="color:#cb2027!important;">{{ __('general.terms_conditions') }}</span>
                                    </a>&nbsp;
                                    {{ __('general.and') }}&nbsp;
                                    <a data-bs-toggle="modal" data-bs-target="#policyModal" onclick="showPolicyTab('privacy')">
                                        <span style="color:#cb2027!important;">{{ __('general.privacy_policy') }}</span>
                                    </a>
                                </label>
                            </div>
                            @error('privacy_policy') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary d-grid w-100">{{ __('general.sign_up') }}</button>
                    </form>

                    <p class="text-center mt-3">
                        <span>{{ __('general.already_have_an_account') }}</span>
                        <a href="{{ route('login') }}"><span>{{ __('general.login') }}</span></a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    @include('website.term-conditions')
</x-auth-layout>
