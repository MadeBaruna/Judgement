@extends('layouts.index')

@section('user_menu')
    <a href="{{ url('/admin/clarifications/' . $contest->id) }}" class="item @yield('active_clarifications')">
        <i class="mail icon"></i>
        Clarifications
    </a>
    <a href="{{ url('/admin/scoreboard/' . $contest->id) }}" class="item @yield('active_scoreboard')">
        <i class="list icon"></i>
        Scoreboard
    </a>
@endsection

@section('content')
    <div class="ui container">
        @yield('div')
    </div>
@endsection