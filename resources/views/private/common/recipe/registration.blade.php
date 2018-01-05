@extends('private.home.layout')

@section('content')
    <div class="col-md-4" style="min-height: 76vh; margin: auto;">

        <div class="panel panel-white" style="background-color: #e3f9ea">
            <div class="panel-body">
                <div>
                    @if($errors->has())
                        <div class="col-md-12 text-danger text-center">
                            @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    @if(session()->has('acknowledgement'))
                        <p class="text-{{ session()->get('alertType') }} text-center text-uppercase">{{ session()->get('acknowledgement') }}</p>
                    @endif

                    <p class="text-center">Create New Account.</p>
                    {{ Form::open(['url'=>'registration']) }}
                    <div class="form-group">
                        {{ Form::text('name',null,['class'=>'form-control','placeholder'=>'Name','required']) }}
                    </div>
                    <div class="form-group">
                        {{ Form::text('username',null,['class'=>'form-control','placeholder'=>'Username','required']) }}
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control password"
                               placeholder="Password" required>
                    </div>
                    <button type="submit" class="btn btn-success btn-block">Create Account</button>
                    <hr>
                    <a href="{{ url('/') }}" class="display-block text-center text-sm text-info">Login If ! Already Have
                        an Account</a>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection