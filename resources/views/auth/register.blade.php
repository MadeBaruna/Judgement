@extends('auth.auth')

@section('title', 'Register')

@section('content')
    <div class="ui middle aligned center aligned grid">
        <div class="column">
            <h2 class="ui header">
                <div class="content">
                    Register to {{ Judgement\Judgement::title() }}
                </div>
            </h2>
            <form class="ui large form {{ count($errors->all()) > 0 || $errors->has('password') ? 'error' : '' }}"
                  method="POST" action="{{ url('/register') }}">
                {{ csrf_field() }}
                <div class="ui segment">
                    <div class="field {{ $errors->has('name') ? 'error' : '' }}">
                        <div class="ui left icon input">
                            <i class="user icon"></i>
                            <input type="text" name="name" placeholder="Your Name" value="{{ old('name') }}">
                        </div>
                    </div>
                    <div class="field {{ $errors->has('email') ? 'error' : '' }}">
                        <div class="ui left icon input">
                            <i class="mail icon"></i>
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
                    <button type="submit" class="ui fluid large primary submit button">Register</button>
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
                <button class="ui button forgot">Forgot Password</button>
            </div>
        </div>
    </div>
@endsection
