<html>
<head>
    <style>
        body {
            background-color: #ecf0f1;
        }

        .box {
            font-family: sans-serif;
            margin: 30px;
            padding: 15px;
            background-color: #fff;
            box-shadow: 0px 0px 6px -1px rgba(204, 204, 204, 1);
            word-break: break-all;
            border-radius: 2px;
        }
    </style>
</head>
<body>
<div class="box">
    <p>Please visit this link to reset your password:</p>
    <a href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a>

    <p>If you ignore this message, your password won't be changed.</p>

    <p>{{ Judgement\Judgement::title() }}</p>
</div>
</body>
</html>

