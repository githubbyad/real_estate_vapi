<x-layout title="Login">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <x-auth-card>
                    <x-slot name="logo">
                        <h2 class="text-center">Login</h2>
                    </x-slot>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Address -->
                        <x-form.input 
                            type="email" 
                            name="email" 
                            label="Email address" 
                            required autofocus
                        />

                        <!-- Password -->
                        <x-form.password 
                            name="password" 
                            label="Password" 
                            required
                        />

                        <!-- Remember Me -->
                        <x-form.checkbox 
                            name="remember" 
                            label="Remember Me"
                        />

                        <div class="d-flex justify-content-between align-items-center">
                            <x-form.button 
                                type="submit" 
                                label="Login" 
                                class="btn-primary"
                            />

                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Forgot your password?
                                </a>
                            @endif
                        </div>
                    </form>
                </x-auth-card>
            </div>
        </div>
    </div>
</x-layout>
