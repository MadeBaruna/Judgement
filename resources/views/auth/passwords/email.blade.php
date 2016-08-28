@extends('auth.auth')

@section('title', 'Reset Password')

<!-- Main Content -->
@section('content')
    @extends('auth.auth')

@section('title', 'Login')

@section('content')
    <div class="ui middle aligned center aligned grid">
        <div class="column">
            <h2 class="ui header">
                <div class="content">
                    Reset Password
                </div>
            </h2>
            <form class="ui large form {{ (session('status')) ? 'success' : ''}} {{ count($errors->all()) > 0 ? 'error' : '' }}"
                  method="POST" action="{{ url('/password/email') }}">
                <div class="ui success message">
                    {{ session('status') }}
                </div>
                {{ csrf_field() }}
                <div class="ui segment">
                    <div class="field {{ $errors->has('email') ? 'error' : '' }}">
                        <div class="ui left icon input">
                            <i class="user icon"></i>
                            <input type="email" name="email" placeholder="E-mail address" value="{{ old('email') }}">
                        </div>
                    </div>
                    <button type="submit" class="ui fluid large primary submit button">Send Password Reset Link</button>
                </div>

                <div class="ui error message">
                    <ul class="list">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </form>

            <div class="ui buttons fluid">
                <button class="ui button login">Login</button>
                <button class="ui button register">Register</button>
            </div>
        </div>
    </div>
@endsection