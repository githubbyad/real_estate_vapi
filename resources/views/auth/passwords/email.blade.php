<x-loginlayout title="Email Password Reset Link">
    <div class="container">
        <div class="row justify-content-center align-items-center h-screen">
            <div class="col-md-5">
                <div class="card rounded-4">
                    <div class="card-header text-center fw-bold text-dark py-3 rounded-top-4">{{ __('Reset Password') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" class="p-2" action="{{ route('password.email') }}">
                            @csrf

                            <x-form.input name="email" type="email" label="{{ __('Email Address') }}" required autofocus />

                            <div class="d-flex justify-content-between align-items-center">
                                <x-form.button type="submit" label="Send Password Reset Link" class="btn-theme w-100" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-loginlayout>
