@extends('layouts.app')

@section('content')
    <section class="auth-hero d-flex align-items-center min-vh-100 py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="auth-card bg-white bg-opacity-75">
                        <h1 class="fw-bold mb-3 text-center">Welcome back</h1>
                        <p class="text-muted text-center mb-4">Sign in to manage orders, wallet, and recycle requests.</p>

                        <form method="POST" action="{{ route('login') }}" novalidate>
                            @csrf
                            <div class="floating-label mb-3">
                                <input id="email" type="email" name="email" class="form-control" placeholder=" " required autofocus>
                                <label for="email">Email address</label>
                            </div>
                            <div class="floating-label mb-3">
                                <input id="password" type="password" name="password" class="form-control" placeholder=" " required>
                                <label for="password">Password</label>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                    <label class="form-check-label" for="remember">Remember me</label>
                                </div>
                                <a href="#" class="text-primary small">Forgot password?</a>
                            </div>
                            <button class="btn btn-primary w-100 mb-3" type="submit">Sign in</button>
                            <p class="text-center text-muted">New artisan? <a href="{{ route('register') }}" class="text-primary fw-semibold">Create account</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
