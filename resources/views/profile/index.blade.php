@extends('layouts.index')

@section('content')
    <div class="ui container">
        <div class="ui two column stackable grid">
            <div class="two wide column">
                <div class="ui vertical pointing labeled icon fluid menu">
                    <a href='{{ url('/profile') }}' class="item @yield('active_profile')">
                        <i class="user icon"></i>
                        @lang('profile.profile')
                    </a>
                    <a href='{{ url('/profile/groups') }}' class="item @yield('active_groups')">
                        <i class="group icon"></i>
                        @lang('profile.groups')
                    </a>
                    <a href='{{ url('/profile/settings') }}' class="item @yield('active_settings')">
                        <i class="setting icon"></i>
                        @lang('profile.settings')
                    </a>
                </div>
            </div>

            <div class="fourteen wide stretched column">
                <div class="ui segment ">
                    @yield('profile')
                </div>
            </div>

        </div>
    </div>

    <div class="ui small modal profile_modal">
        <div class="header">
            @lang('profile.profile_picture')
        </div>
        <div class="image content">
            <div class="ui medium image">
                <img class="ui medium rounded image" src="{{ Auth::user()->picture() }}">
                <div class="ui bottom attached progress">
                    <div class="bar"></div>
                </div>
            </div>
            <div class="description">
                <p>@lang('profile.upload_message')</p>
                <form class="ui form profile_picture" name="profile_picture" method="POST"
                      action="{{ url('/profile') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="ui action input fluid">
                        <input type="text" readonly class='loader active inline'>
                        <input type="file" name="image" accept="image/*">
                        <div class="ui icon button">
                            <i class="upload icon"></i>
                        </div>
                    </div>

                    <div class="ui error message">
                        <p></p>
                    </div>
                </form>
            </div>
        </div>
        <div class="actions">
            <div class="ui black deny button cancel">
                @lang('profile.cancel')
            </div>
            <div class="ui positive right labeled icon button accept">
                @lang('profile.save')
                <i class="check icon"></i>
            </div>
        </div>
    </div>
@endsection
