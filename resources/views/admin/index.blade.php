@extends('layouts.index')

@section('content')
    <div class="ui container">
        <div class="ui two column stackable grid">
            <div class="two wide column">
                <div class="ui vertical pointing labeled icon fluid menu">
                    <a href='{{ url('/admin/contests') }}' class="item @yield('active_contests', '')">
                        <i class="cubes icon"></i>
                        Contests
                    </a>
                    <a href='{{ url('/admin/problems') }}' class="item @yield('active_problems', '')">
                        <i class="cube icon"></i>
                        Problems
                    </a>
                    <a href='{{ url('/admin/languages') }}' class="item @yield('active_languages', '')">
                        <i class="code icon"></i>
                        Languages
                    </a>
                    <a href='{{ url('/admin/users') }}' class="item @yield('active_users', '')">
                        <i class="user icon"></i>
                        Users
                    </a>
                    <a href='{{ url('/admin/categories') }}' class="item @yield('active_categories', '')">
                        <i class="tags icon"></i>
                        Categories
                    </a>
                    <a href='{{ url('/admin/settings') }}' class="item @yield('active_settings', '')">
                        <i class="settings icon"></i>
                        Settings
                    </a>
                </div>
            </div>

            <div class="fourteen wide column">
                <div class="ui top attached segment">
                    @yield('admin_breadcrumb')
                </div>
                <div class="ui bottom attached segment">
                    @yield('admin')
                </div>
            </div>

        </div>
    </div>
@endsection
