@extends('layouts.index')

@section('user_menu')
    <a href="{{ url('/contest/' . $contest->id) }}" class="item @yield('active_problems')">
        <i class="cube icon"></i>
        Problems
    </a>
    <a class="item">
        <i class="inbox icon"></i>
        Submission
    </a>
    <a class="item">
        <i class="mail icon"></i>
        Confirmation
    </a>
    <a href="{{ url('/contest/' . $contest->id . '/scoreboard') }}" class="item @yield('active_scoreboard')">
        <i class="list icon"></i>
        Scoreboard
    </a>
@endsection

@section('content')
    @yield('box');
@endsection
