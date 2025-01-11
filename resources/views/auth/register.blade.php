@extends('adminlte.layouts.auth')

@section('content')
<body class="hold-transition register-page">
    <div class="register-box">
        <div class="register-logo">
            <a href="{{ route('home') }}"><b>{{ config('app.name', 'Laravel') }}</b> 1.0</a>
        </div>

        <div class="card">
            <div class="card-body register-card-body">
                <p class="login-box-msg">Register a new membership</p>

                <form action="{{ route('register') }}" method="post">
                    @csrf

                    <!-- Input untuk Nama -->
                    <div class="input-group mb-3">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Full name" value="{{ old('name') }}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Input untuk Email -->
                    <div class="input-group mb-3">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email" value="{{ old('email') }}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Input untuk Password -->
                    <div class="input-group mb-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Input untuk Konfirmasi Password -->
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password_confirmation" placeholder="Retype password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Pilihan Role -->
                    <div class="form-group mb-3 text-center">
                        <label for="role">Select your role</label>
                        <div class="btn-group btn-group-toggle d-flex" data-toggle="buttons">
                            <label class="btn btn-outline-primary flex-fill">
                                <input type="radio" name="role_id" value="1" autocomplete="off">
                                <i class="fas fa-user-shield"></i> Admin
                            </label>
                            <label class="btn btn-outline-success flex-fill">
                                <input type="radio" name="role_id" value="2" autocomplete="off">
                                <i class="fas fa-chalkboard-teacher"></i> Teacher
                            </label>
                            <label class="btn btn-outline-info flex-fill">
                                <input type="radio" name="role_id" value="3" autocomplete="off">
                                <i class="fas fa-user-graduate"></i> Student
                            </label>
                            <label class="btn btn-outline-warning flex-fill">
                                <input type="radio" name="role_id" value="4" autocomplete="off">
                                <i class="fas fa-user-friends"></i> Parent
                            </label>
                        </div>
                        @error('role_id')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Tombol Submit -->
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                                <label for="agreeTerms">
                                    I agree to the <a href="#">terms</a>
                                </label>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">{{ __('Register') }}</button>
                        </div>
                    </div>
                </form>

                <!-- Pilihan Login -->
                @if (Route::has('login'))
                <a href="{{ route('login') }}" class="text-center">I already have a membership</a>
                @endif
            </div>
        </div>
    </div>
</body>
@endsection
