<!DOCTYPE html>

<?php
$title = Judgement\Judgement::title();
?>

<html>
<head>
    <title>@yield('title') - {{ $title }}</title>

    <link rel="stylesheet" type="text/css" href="/assets/css/semantic.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/auth.css">
</head>
<body>

<div class="ui center aligned middle aligned grid">
    <div class="box">
        <div class="ui inverted dimmer">
            <div class="ui text loader"></div>
        </div>
        @yield('content')
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="/assets/js/semantic.min.js"></script>
<script src="/assets/js/auth.js"></script>
</body>
</html>