@extends('layouts.guess')

@section('login')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-5 col-xl-4">
                <div class="card shadow-lg o-hidden border-0 my-5">
                    <div class="card-body p-0">
                        <div class="p-5">
                            <div class="text-center">
                                <h4 class="text-dark mb-4">Sign In</h4>
                            </div>
                            <form action="{{ route('login') }}" method="POST">
                                @csrf
                                <div class="form-floating mb-3">
                                    <input class="form-control @error('email') is-invalid @enderror" type="email"
                                        id="email" aria-describedby="email" placeholder="Email" name="email"
                                        value="{{ old('email') }}" required autofocus autocomplete="username">
                                    <label for="email">Email</label>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <p>{{ $message }}</p>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-floating mb-3">
                                    <input class="form-control" type="password" id="password" placeholder="Password"
                                        name="password" required autocomplete="current-password">
                                    <label for="password">Password</label>
                                </div>
                                <div class="mb-3">
                                    <div class="custom-control custom-checkbox small">
                                        <div class="form-check"><input class="form-check-input custom-control-input"
                                                type="checkbox" id="remember_me"><label
                                                class="form-check-label custom-control-label" for="remember_me">Remember
                                                Me</label></div>
                                    </div>
                                </div><button class="btn btn-primary d-block btn-user w-100" type="submit">Login</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
