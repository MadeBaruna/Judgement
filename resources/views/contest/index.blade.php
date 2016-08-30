@extends('layouts.index')

@section('user_menu')
    <a href="{{ url('/contest/' . $contest->id) }}" class="item @yield('active_problems')">
        <i class="cube icon"></i>
        Problems
    </a>
    <a href="{{ url('/contest/' . $contest->id) . '/submissions'}}" class="item @yield('active_submissions')">
        <i class="inbox icon"></i>
        Submissions
    </a>
    <a href="{{ url('/contest/' . $contest->id . '/clarifications') }}" class="item @yield('active_clarifications')"">
        <i class="mail icon"></i>
        Clarifications
    </a>
    <a href="{{ url('/contest/' . $contest->id . '/scoreboard') }}" class="item @yield('active_scoreboard')">
        <i class="list icon"></i>
        Scoreboard
    </a>
@endsection

@section('content')
    @yield('box');
@endsection
