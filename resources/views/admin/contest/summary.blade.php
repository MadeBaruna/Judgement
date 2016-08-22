@extends('admin.index')

@section('title', $contest->name)

@section('active_contests', 'active')

@section('admin_breadcrumb')
    <a href="{{ url('/admin/contests/edit/' . $contest->id) }}" class="ui right floated labeled icon button delete_contest">
        <i class="edit icon"></i>
        Edit Contest
    </a>

    <div class="ui breadcrumb">
        <h1>
            Contest Summary
        </h1>
        <div class="section">
            <i class="home icon"></i>
            Dashboard
        </div>
        <i class="right chevron icon divider"></i>
        <a href="{{ url('/admin/contests') }}" class="section">
            <i class="cubes icon"></i>
            Contests
        </a>
        <i class="right chevron icon divider"></i>
        <div class="section">
            {{ $contest->name }}
        </div>
    </div>
@endsection

@section('admin')
    <div class="contests">
        <h4>Contest name</h4>
        <h3>{{ $contest->name }}</h3>
        <h4>Type</h4>
        <h3>{{ ucfirst($contest->type) }}</h3>
        @php
            $start = Carbon\Carbon::parse($contest->start_time);
            $end = Carbon\Carbon::parse($contest->end_time);

            $startDateTime = $start->formatLocalized('%A %d %B %Y %T');
            $endDateTime = $end->formatLocalized('%A %d %B %Y %T')
        @endphp
        <h4>Start time</h4>
        <h3 class="start_time">{{ $startDateTime }}</h3>
        <h4>End time</h4>
        <h3 class="end_time">{{ $endDateTime }}</h3>
        <h4>Programming Languages</h4>
        @if(count($languages) > 0)
        @foreach($languages as $language)
            <div class="ui black label">
                {{ $language->name }}
            </div>
        @endforeach
        @else
            <h3>No language</h3>
        @endif
        <h4>Categories</h4>
        @if(count($categories) > 0)
            @foreach($categories as $category)
                <div class="ui black label">
                    {{ $category->name }}
                </div>
            @endforeach
        @else
            <h3>All Categories</h3>
        @endif
        <h4>Allowed Users</h4>
        <div class="ui horizontal list">
            @if(count($emails) > 0)
                @foreach($emails as $email)
                    <div class="item">
                        @php
                            $user = \Judgement\User::where('email', '=', $email->email)->first();
                        @endphp
                        @if($user)
                            <img class="ui avatar image" src="{{ $user->picture() }}">
                        @else
                            <img class="ui avatar image" src="/assets/images/default.png">
                        @endif
                        <div class="content">
                            @if($user)
                                <div class="header">{{ $user->name }}</div>
                            @else
                                <div class="header">Unregistered</div>
                            @endif
                            {{ $email->email }}
                        </div>
                    </div>
                @endforeach
            @else
                <h3>All user allowed</h3>
            @endif
        </div>
        <h4>Status</h4>
        <h3>{{ $contest->status }} <span class="timer"></span></h3>
    </div>
@endsection
