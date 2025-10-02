<x-loginlayout title="Login">
    <div class="container mt-5">
        <div class="row justify-content-center align-items-center h-screen">
            <div class="col-md-5">
                <x-auth-card background="white">
                    <x-slot name="logo">
                        <div class="container d-flex justify-content-center align-items-center">
                            <a href="/">
                                <img src="{{ $settings->logo ?? asset('logo.png') }}" alt="Logo" class="w-75" style="max-height: 200px;">
                            </a>
                        </div>
                    </x-slot>

                    <form method="POST" class="p-2" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Address -->
                        <x-form.input type="email" name="email" label="Email address" required autofocus />

                        <!-- Password -->
                        <x-form.password name="password" label="Password" required />
                     
                        <!-- Remember Me -->
                        <x-form.checkbox name="remember" label="Remember Me" />

                        <div class="d-flex justify-content-between align-items-center">
                            <x-form.button type="submit" label="Login" class="btn-theme w-100" rounded="full" />
                        </div>

                        @if (Route::has('password.request'))
                            <div class="text-center mt-3">
                                <a class="btn btn-link text-decoration-none text-gray fs-7 fw-bold" href="{{ route('password.request') }}">
                                    Forgot your password?
                                </a>
                            </div>
                        @endif
                    </form>
                </x-auth-card>
            </div>
        </div>
    </div>
</x-loginlayout>
