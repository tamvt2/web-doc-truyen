@extends('layouts.index')

@section('content')
<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                        </div>
                        @include('layouts/alert')
                        <form class="user" action="{{ URL::to('register') }}" method="post">
                            {{ csrf_field()}}
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" name="name"
                                    placeholder="Name">
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control form-control-user" name="email"
                                    placeholder="Email Address">
                            </div>
                            <div class="form-group">
                                <label class="mx-3">Đọc giả</label>
                                <label class="switch">
                                    <input type="checkbox" name="role" value="admin">
                                    <span class="slider round"></span>
                                </label>
                                <label for="role" class="ml-3 mb-0">Tác Giả</label>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-user"
                                    name="password" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-user"
                                    name="password_confirmation" placeholder="Repeat Password">
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">Register Account</button>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="login">Already have an account? Login!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
