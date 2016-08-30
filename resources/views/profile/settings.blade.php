@extends('profile.index')

@section('title', 'Settings')

@section('active_settings', 'active')

@section('profile')
    <div class="profile">
        <form class="ui form {{ count($errors->all()) > 0 ? 'error' : '' }}"
              method="POST" action="{{ url('/profile/settings') }}">
            {{ csrf_field() }}
            <div class="field {{ $errors->has('name') ? 'error' : '' }}">
                <label>@lang('profile.language')</label>
                <div class="ui selection dropdown type">
                    <input type="hidden" name="locale"
                           value="{{ Auth::user()->locale ? Auth::user()->locale : Lang::locale() }}">
                    <i class="dropdown icon"></i>
                    <div class="default text">Select The Problem</div>
                    <div class="menu">
                        @php($locales = \Config::get('app.available_locale'))
                        @foreach($locales as $key => $locale)
                            <div class="item" data-value="{{ $key }}">
                                {{ $locale }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <button type="submit" class="ui primary submit button">@lang('profile.change')</button>
            <a href="{{ url('/') }}" class="ui button">@lang('profile.cancel')</a>

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
