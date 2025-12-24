@extends('layouts.app')

@section('content')
    <section class="auth-hero d-flex align-items-center min-vh-100 py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="auth-card bg-white bg-opacity-75">
                        <h1 class="fw-bold mb-3 text-center">Join DecoRecycle</h1>
                        <p class="text-muted text-center mb-4">Create an account to shop, recycle, and earn wallet credits.</p>

                        <form method="POST" action="{{ route('register') }}" novalidate>
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6 floating-label">
                                    <input id="name" type="text" name="name" class="form-control" placeholder=" " required>
                                    <label for="name">Full name</label>
                                </div>
                                <div class="col-md-6 floating-label">
                                    <input id="username" type="text" name="username" class="form-control" placeholder=" ">
                                    <label for="username">Username (optional)</label>
                                </div>
                                <div class="col-md-6 floating-label">
                                    <input id="email" type="email" name="email" class="form-control" placeholder=" " required>
                                    <label for="email">Email</label>
                                </div>
                                <div class="col-md-6 floating-label">
                                    <input id="phone" type="tel" name="phone" class="form-control" placeholder=" ">
                                    <label for="phone">Phone</label>
                                </div>
                                <div class="col-md-6 floating-label">
                                    <input id="password" type="password" name="password" class="form-control" placeholder=" " required>
                                    <label for="password">Password</label>
                                </div>
                                <div class="col-md-6 floating-label">
                                    <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" placeholder=" " required>
                                    <label for="password_confirmation">Confirm password</label>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary w-100" type="submit">Create account</button>
                                </div>
                                <div class="col-12 text-center text-muted">
                                    Already have an account? <a href="{{ route('login') }}" class="text-primary fw-semibold">Sign in</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
