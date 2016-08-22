<!DOCTYPE html>

<?php
$title = Judgement\Judgement::title();
$time = Carbon\Carbon::now()->toTimeString();
?>

<html>
<head>
    <title>@yield('title') - {{ $title }}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" type="text/css" href="/assets/css/semantic.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/github-markdown.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/index.css">
</head>
<body>

<div class="ui top fixed menu menu-header">
    <div class="ui container">
        <a href="{{ url('/') }}" class="header item"><h2><i class="cube icon"></i> {{ $title }}</h2></a>
        <div class="item servertime" data-content="@lang('header.servertime')" data-position="bottom center">
            <i class="clock icon"></i>
            <span class="time">{{ $time }}</span>
        </div>
        <div class="right menu">
            @if (Auth::guest())
                <a href="{{ url('/login') }}" class="item">@lang('header.login')</a>
                <a href="{{ url('/register') }}" class="item">@lang('header.register')</a>
            @else
                <div class="ui dropdown link item">
                    <span class="text">
                        <img class="ui avatar image" src="{{ Auth::user()->picture() }}">
                        {{ Auth::user()->name }}
                    </span>
                    <i class="dropdown icon"></i>
                    <div class="menu">
                        @if(Auth::user()->isAdmin())
                            <a href="{{ url('/admin') }}" class="item">
                                <i class="dashboard icon"></i> @lang('header.admin')
                            </a>
                            <div class="divider"></div>
                        @endif
                        <a href="{{ url('/profile') }}" class="item">
                            <i class="user icon"></i> @lang('header.profile')
                        </a>
                        <a href="{{ url('/settings') }}" class="item">
                            <i class="settings icon"></i> @lang('header.settings')
                        </a>
                        <div class="divider"></div>
                        <a href="{{ url('/logout') }}" class="item">
                            <i class="log out icon"></i> @lang('header.logout')
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<div class="ui main">
    @yield('content')
</div>

@include('layouts.footer')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="/assets/js/semantic.min.js"></script>
<script src="/assets/js/moment-with-locales.js"></script>
<script src="//cdn.mathjax.org/mathjax/latest/MathJax.js?config=AM_HTMLorMML"></script>
<script src="/assets/js/countdown.min.js"></script>
<script src="/assets/js/index.js"></script>
<script src="/assets/js/profile.js"></script>
<script src="/assets/js/admin.js"></script>
</body>
</html>