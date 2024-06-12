@extends('layouts.index')

@section('content')
<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                <div class="col-lg-6">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                        </div>
                        @include('layouts/alert')
                        <form class="user" action="{{ URL::to('login') }}" method="post">
                            {{ csrf_field()}}
                            <div class="form-group">
                                <input type="email" class="form-control form-control-user"
                                    name="email" aria-describedby="emailHelp"
                                    placeholder="Enter Email Address...">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-user"
                                    name="password" placeholder="Password">
                            </div>
                            <button class="btn btn-primary btn-user btn-block">
                                Login
                            </button>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="register">Create an Account!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
