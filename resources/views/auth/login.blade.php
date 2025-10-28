<x-auth-layout :page-title="$pageTitle">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="py-4">
            <div class="card shadow mx-3">
                <div class="card-body">
                    @include('auth.logo', ['type' => 'login'])

                    <form id="formAuthentication" method="POST" action="{{ route('login') }}" class="mb-3">
                        @csrf

                        <div class="mb-3">
                            <label for="login" class="form-label">{{ __('general.email_username') }}</label>
                            <input type="text" class="form-control" id="login" name="login"
                                   value="{{ old('login') }}" autofocus autocomplete="username" />
                            @error('login')
                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('general.password') }}</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" name="password" class="form-control"
                                       placeholder="••••••••••" autocomplete="current-password" />
                                <span type="button" class="input-group-text" onclick="togglePassword('password', this)">
                                    <i class="ti ti-eye-off"></i>
                                </span>
                            </div>
                            @error('password')
                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check d-flex justify-content-between">
                                <div>
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="remember-me"
                                        name="remember"
                                        value="0"
                                        onchange="this.value = this.checked ? 1 : 0;"
                                    />
                                    <label class="form-check-label" for="remember-me">
                                        {{ __('general.remember_me') }}
                                    </label>
                                </div>
                                <a href="javascript:void(0);" onclick="resetPasswordRequest();" class="text-primary">
                                    {{ __('general.reset_password') }}
                                </a>
                            </div>
                            @error('remember')
                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary d-grid w-100">
                            {{ __('general.sign_in') }}
                        </button>
                    </form>

                    <p class="text-center">
                        <span>{{ trans('general.dont_have_a_account') }}</span>
                        <a href="{{ route('register') }}">{{ trans('general.create_an_account') }}</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-auth-layout>
