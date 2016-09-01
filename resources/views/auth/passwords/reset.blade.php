@extends('auth.auth')

@section('title', 'Reset Password')

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
                  method="POST" action="{{ url('/password/reset') }}">
                <div class="ui success message">
                    {{ session('status') }}
                </div>
                {{ csrf_field() }}
                <div class="ui segment">
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="field {{ $errors->has('email') ? 'error' : '' }}">
                        <div class="ui left icon input">
                            <i class="user icon"></i>
                            <input type="email" name="email" placeholder="E-mail address" value="{{ old('email') }}">
                        </div>
                    </div>
                    <div class="field {{ $errors->has('password') ? 'error' : '' }}">
                        <div class="ui left icon input">
                            <i class="lock icon"></i>
                            <input type="password" name="password" placeholder="Password">
                        </div>
                    </div>
                    <div class="field {{ $errors->has('password') ? 'error' : '' }}">
                        <div class="ui left icon input">
                            <i class="lock icon"></i>
                            <input type="password" name="password_confirmation" placeholder="Confirm Password">
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
        </div>
    </div>
@endsection
