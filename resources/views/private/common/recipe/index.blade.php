@extends('private.home.layout')

@section('content')
    <div class="col-md-4" style="min-height: 76vh; margin: auto;">
        <div class="panel panel-white" style="background-color: #e3f9ea">
            <div class="panel-body">
                <div>
                    <p class="text-center text-danger">Username: monir<br>Password: tigger</p>
                    @if(session()->has('acknowledgement'))
                        <p class="text-{{ session()->get('alertType') }} text-center text-uppercase">{{ session()->get('acknowledgement') }}</p>
                    @endif
                    <p class="text-center">Please login into your account.</p>
                    {{ Form::open(['url'=>'login']) }}
                    <div class="form-group">
                        {{ Form::text('username',null,['class'=>'form-control','placeholder'=>'Username']) }}
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control password"
                               placeholder="Password" required>
                    </div>
                    <button type="submit" class="btn btn-success btn-block">Login</button>
                    <hr>
                    <a href="{{ url('registration') }}" class="display-block text-center text-sm text-info">Create New Account</a>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection