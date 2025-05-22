@extends('layouts.master')

@section('title', 'User authentication')

@section('body')
    <div class="container-fluid">
        <div class="row">
            <div>
                <ul class="nav nav-tabs mb-3 justify-content-end">
                    <li class="nav-item">
                        <a class="aol-navbar nav-link navbar-brand active  " data-bs-toggle="tab"
                            href="#login-tab">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="aol-navbar nav-link navbar-brand " data-bs-toggle="tab" href="#register-tab">Register</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="tab-content">
                <div class="tab-pane active" id="login-tab">
                    <form id="login-form" action="{{ route('login') }}" method="post">
                        @csrf
                        <div class="form-group mb-3">
                            <input type="text" name="email" class="form-control" placeholder="Email..." />
                        </div>

                        <div class="form-group mb-3">
                            <input type="password" name="password" class="form-control" placeholder="Password..." />
                        </div>

                        <div class="form-group text-center mb-3">
                            <label for="login-submit" class="btn aol-btn-send"><i class="bi bi-door-open"></i>
                                Login</label>
                            <input id="login-submit" class="d-none" type="submit" value="Login">
                        </div>
                    </form>
                </div>

                <div class="tab-pane" id="register-tab">
                    <form id="register-form" action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <input type="text" name="name" class="form-control" placeholder="Your name..." />
                        </div>

                        <div class="form-group mb-3">
                            <input type="text" name="email" class="form-control" placeholder="Your email..." />
                        </div>

                        <div class="form-group mb-3">
                            <input type="password" name="password" class="form-control" placeholder="Type password..." />
                        </div>

                        <div class="form-group mb-3">
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="Re-type password..." />
                        </div>

                        <div class="form-group text-center mb-3">
                            <label for="register-submit" class="btn aol-btn-send"><i class="bi bi-person-plus"></i>
                                Register</label>
                            <input id="register-submit" class="d-none" type="submit" value="Register">
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection