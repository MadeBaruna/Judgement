@extends('profile.index')

@section('title', 'Change Profile')

@section('active_profile', 'active')

@section('profile')
    <div class="profile">
        <form class="ui form {{ count($errors->all()) > 0 ? 'error' : '' }}"
              method="POST" action="{{ url('/profile/edit') }}">
            {{ csrf_field() }}
            <div class="field {{ $errors->has('name') ? 'error' : '' }}">
                <label>@lang('profile.name')</label>
                <input type="text" name="name" placeholder="@lang('profile.name')" value="{{ Auth::user()->name }}">
            </div>
            <div class="field disabled">
                <label>@lang('profile.email')</label>
                <input class="disabled" type="email" name="email" placeholder="@lang('profile.email')" value="{{ Auth::user()->email }}">
            </div>
            <div class="field">
                <label>@lang('profile.institution')</label>
                <input type="text" name="institution" placeholder="@lang('profile.institution')" value="{{ Auth::user()->institution }}">
            </div>
            <div data-tooltip="@lang('profile.leave_blank')"
                 data-position="bottom left" class="field {{ $errors->has('password') ? 'error' : '' }}">
                <label>@lang('profile.old_password')</label>
                <input type="password" name="password" placeholder="@lang('profile.old_password')">
            </div>
            <div class="field {{ $errors->has('new_password') ? 'error' : '' }}">
                <label>@lang('profile.new_password')</label>
                <input type="password" name="new_password" placeholder="@lang('profile.new_password')">
            </div>
            <div class="field {{ $errors->has('new_password') ? 'error' : '' }}">
                <label>@lang('profile.confirm_new_password')</label>
                <input type="password" name="new_password_confirmation" placeholder="@lang('profile.confirm_new_password')">
            </div>
            <button type="submit" class="ui primary submit button">@lang('profile.change')</button>
            <a href="{{ url('/profile') }}" class="ui button">@lang('profile.cancel')</a>

            <div class="ui error message">
                <ul class="list">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </form>
    </div>
@endsection
