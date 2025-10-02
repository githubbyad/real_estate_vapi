<x-loginlayout title="Reset Password">
    <div class="container">
        <div class="row justify-content-center align-items-center h-screen">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">{{ __('Reset Password') }}</div>

                    <div class="card-body">
                        <form method="POST" class="p-2" action="{{ route('password.update') }}">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <x-form.input name="email" type="email" rounded="full" label="{{ __('Email Address') }}"
                                required autofocus />

                            <x-form.input name="password" type="password" rounded="full" label="{{ __('Password') }}"
                                required />

                            <x-form.input name="password_confirmation" type="password" rounded="full"
                                label="{{ __('Confirm Password') }}" required />

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-theme">
                                        {{ __('Reset Password') }}
                                    </button>
                                </div>
                            </div>                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-loginlayout>
