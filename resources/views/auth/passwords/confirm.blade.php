<x-loginlayout title="Confirm Password">
    <div class="container">
        <div class="row justify-content-center align-items-center h-screen">
            <div class="col-md-5">
                <div class="card rounded-4">
                    <div class="card-header text-center fw-bold text-dark py-3 rounded-top-4">{{ __('Confirm Password') }}</div>

                    <div class="card-body">
                        <p class="text-gray mb-3 fw-bold fs-7">
                        {{ __('Please confirm your password before continuing.') }}
                        </p>

                        <form method="POST" class="p-2" action="{{ route('password.confirm') }}">
                            @csrf

                            <x-form.input name="password" type="password" label="{{ __('Password') }}" rounded="full"
                                required autofocus />

                            <div class="d-flex justify-content-between align-items-center">
                                <x-form.button type="submit" label="Confirm Password" class="btn-theme w-100"
                                    rounded="full" />
                            </div>

                            @if (Route::has('password.request'))
                                <div class="text-center mt-3">
                                    <a class="btn btn-link text-decoration-none text-gray fs-7 fw-bold"
                                        href="{{ route('password.request') }}">
                                        Forgot your password?
                                    </a>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-loginlayout>
