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
            <div class="ui top attached clearing segment">
                <img class="ui avatar image" src="{{ $group->picture() }}"/> {{ $group->name }}
                <a class="ui right floated compact small button">Edit</a>
            </div>
            <div class="ui secondary bottom attached segment">
                <div class="ui horizontal list">
                    @foreach($members as $member)
                        <div class="item">
                            <img class="ui avatar image" src="{{ $member->picture() }}">
                            <div class="content">
                                {{ $member->name }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        @if(count($groups) == 0)
            <p>You have no group.</p>
        @endif
    </div>
@endsection
