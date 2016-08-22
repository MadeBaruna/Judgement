@extends('profile.index')

@section('title', 'Profile')

@section('active_profile', 'active')

@section('profile')
    <div class="profile">
        <div class="ui two columns grid">
            <div class="three wide column">
                <div class="ui small image">
                    <div class="ui dimmer">
                        <div class="content">
                            <div class="center">
                                <h2 class="ui inverted">Change Picture</h2>
                            </div>
                        </div>
                    </div>
                    <img class="ui rounded image current_picture" src="{{ Auth::user()->picture() }}">
                </div>
            </div>
            <div class="thirteen wide column">
                <div class="content">
                    <h4>{{ strtoupper(trans('profile.name')) }}</h4>
                    <h2>{{ Auth::user()->name }}</h2>
                    <h4>{{ strtoupper(trans('profile.email')) }}</h4>
                    <h2>{{ Auth::user()->email }}</h2>
                    <h4>{{ strtoupper(trans('profile.institution')) }}</h4>
                    @if(Auth::user()->institution == '')
                        <h2>-</h2>
                    @else
                        <h2>{{ Auth::user()->institution }}</h2>
                    @endif
                    <a href="{{ url('/profile/edit') }}" class="ui button">@lang('profile.change_profile')</a>
                </div>
            </div>
        </div>
    </div>
@endsection
