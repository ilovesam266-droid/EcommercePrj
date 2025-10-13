@extends('layouts.auth-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Page Title Here....')
@section('content')
<div class="card-group d-block d-md-flex row">
    <div class="card col-md-7 p-4 mb-0">
        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf
            <div class="card-body">
                <h1>Login</h1>
                <p class="text-body-secondary">Sign In to your account</p>
                <div class="input-group mb-3"><span class="input-group-text">
                        <svg class="icon">
                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-user"></use>
                        </svg></span>
                    <input class="form-control" type="text" placeholder="Email/Username" name="login_id"
                        value={{ old('login_id') }}>
                </div>
                @error('login_id')
                    <span class="text-danger ml-1">{{ $message }}</span>
                @enderror
                <div class="input-group mb-4"><span class="input-group-text">
                        <svg class="icon">
                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-lock-locked"></use>
                        </svg></span>
                    <input class="form-control" type="password" placeholder="Password" name="password">
                </div>
                @error('password')
                    <span class="text-danger ml-1">{{ $message }}</span>
                @enderror
                <div class="row mb-4">
                    <div class="col-md-6 d-flex justify-content-center">
                        <!-- Checkbox -->
                        <div class="form-check mb-3 mb-md-0">
                            <input class="form-check-input" type="checkbox" value="" id="remember" name="remember" checked />
                            <label class="form-check-label" for="loginCheck"> Remember me </label>
                        </div>
                    </div>

                    <div class="col-md-6 d-flex justify-content-center">
                        <!-- Simple link -->
                        <a href="#!">Forgot password?</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <input class="btn btn-primary px-4" type="submit" value="Login" />
                    </div>
                </div>
            </div>
        </form>

    </div>
    <div class="card col-md-5 text-white bg-primary py-5">
        <div class="card-body text-center">
            <div>
                <h2>Sign up</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                    incididunt ut labore et dolore magna aliqua.</p>
                <button class="btn btn-lg btn-outline-light mt-3" type="button">Register Now!</button>
            </div>
        </div>
    </div>
</div>

@endsection
