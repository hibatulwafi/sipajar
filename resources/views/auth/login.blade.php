@extends('layouts.auth')

@section('content')
<div class="card">
    <div class="card-body">

        <h3 class="text-center m-0">
            <a href="index.html" class="logo logo-admin"><img src="images/logo npa 2.png" height="60" alt="logo"></a>
            </h3>

        <div class="p-3">
            <h4 class="text-muted font-18 m-b-5 text-center">Selamat Datang !</h4>
            <p class="text-muted text-center">Silahkan masuk untuk melanjutkan.</p>

            <form class="form-horizontal m-t-30" action="{{ route('loginpost') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control @error('username') is-invalid @enderror" name='user_email' id="user_email" placeholder="Enter username">
                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="userpassword">Password</label>
                    <input type="password" class="form-control @error('user_password') is-invalid @enderror" name='password' id="password" placeholder="Enter password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group row m-t-20">
                    <div class="col-sm-6">
                       
                    </div>
                    <div class="col-sm-6 text-right">
                        <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Log In</button>
                    </div>
                </div>

            </form>

            @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button> 
                <strong>{{ $message }}</strong>
            </div>
            @endif

        </div>

    </div>
</div>
@endsection
