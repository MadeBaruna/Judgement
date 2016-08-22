@extends('profile.index')

@section('title', 'Profile')

@section('active_groups', 'active')

@section('profile')
    <a href="{{ url('/profile/groups/new') }}" class="ui right floated green labeled icon button">
        <i class="add icon"></i>
        Create New Group
    </a>
    <div class="profile">
        <h1>Your Groups</h1>
        @foreach($groups as $group)
            @php($members = $group->members)
            <div class="ui divided selection list">
                <div class="item">
                    <img class="ui avatar image" src="{{ Auth::user()->picture() }}">
                    <div class="content">
                        <div class="header">{{ $group->name }}</div>
                        <div class="description">{{ count($members) }} Members</div>
                        <div class="ui horizontal middle aligned list">
                            @foreach($members as $member)
                                <div class="item">
                                    <img class="ui avatar image" src="{{ Auth::user()->picture() }}">
                                    <div class="content">
                                        <div class="header">{{ $member->name }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
