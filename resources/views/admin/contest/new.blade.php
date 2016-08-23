@extends('admin.index')

@section('title', 'New Contest')

@section('active_contests', 'active')

@section('admin_breadcrumb')
    <div class="ui breadcrumb">
        <h1>
            New Contest
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
            New
        </div>
    </div>
@endsection

@section('admin')
    <div class="contests">
        <form class="ui form {{ count($errors->all()) > 0 ? 'error' : '' }}"
              method="POST" action="{{ url('/admin/contests/new') }}">
            {{ csrf_field() }}
            <div class="field {{ $errors->has('contest_name') ? 'error' : '' }}">
                <label>Contest name</label>
                <input type="text" name="contest_name" placeholder="Contest name" value="{{ old('contest_name') }}">
            </div>
            <div class="field {{ $errors->has('type') ? 'error' : '' }}">
                <label>Contest type</label>
                <div class="ui selection dropdown type">
                    <input type="hidden" name="type" value="{{ old('type') }}">
                    <i class="dropdown icon"></i>
                    <div class="default text">Contest type</div>
                    <div class="menu">
                        <div class="item" data-value="individual">
                            <i class="user icon"></i>
                            Individual
                        </div>
                        <div class="item" data-value="group">
                            <i class="group icon"></i>
                            Group
                        </div>
                    </div>
                </div>
            </div>
            <input class="start_time_input" type="hidden" name="start_time">
            <div class="field start_date {{ $errors->has('start_time') ? 'error' : '' }}">
                <label>Start time</label>
                <div class="inline fields">
                    <div class="two wide field">
                        <input class="date" name="start_field_date" type="number" min="1" max="31" placeholder="Date"
                               value="{{ old('start_field_date') }}">
                    </div>
                    <div class="two wide field">
                        <input class="month" name="start_field_month" type="number" min="1" max="12" placeholder="Month"
                               value="{{ old('start_field_month') }}">
                    </div>
                    <div class="two wide field">
                        <input class="year" name="start_field_year" type="number" min="1" placeholder="Year"
                               value="{{ old('start_field_year') }}">
                    </div>
                    <div class="one wide field"></div>
                    <div class="two wide field">
                        <input class="hour" name="start_field_hour" type="number" min="0" max="23" placeholder="Hour"
                               value="{{ old('start_field_hour') }}">
                    </div>
                    <div class="two wide field">
                        <input class="minute" name="start_field_minute" type="number" min="0" max="59"
                               placeholder="Minute"
                               value="{{ old('start_field_minute') }}">
                    </div>
                    <div class="two wide field">
                        <input class="second" name="start_field_second" type="number" min="0" max="59"
                               placeholder="Second"
                               value="{{ old('start_field_second') }}">
                    </div>
                    <div class="four wide field">
                        <div class="ui disabled input">
                            <input class="start_time_parsed" value="">
                        </div>
                    </div>
                </div>
            </div>
            <input class="end_time_input" type="hidden" name="end_time">
            <div class="field end_date {{ $errors->has('end_time') ? 'error' : '' }}">
                <label>End time</label>
                <div class="inline fields">
                    <div class="two wide field">
                        <input class="date" name="end_field_date" type="number" min="1" max="31" placeholder="Date"
                               value="{{ old('end_field_date') }}">
                    </div>
                    <div class="two wide field">
                        <input class="month" name="end_field_month" type="number" min="1" max="12" placeholder="Month"
                               value="{{ old('end_field_month') }}">
                    </div>
                    <div class="two wide field">
                        <input class="year" name="end_field_year" type="number" min="1" placeholder="Year"
                               value="{{ old('end_field_year') }}">
                    </div>
                    <div class="one wide field"></div>
                    <div class="two wide field">
                        <input class="hour" name="end_field_hour" type="number" min="0" max="23" placeholder="Hour"
                               value="{{ old('end_field_hour') }}">
                    </div>
                    <div class="two wide field">
                        <input class="minute" name="end_field_minute" type="number" min="0" max="59"
                               placeholder="Minute"
                               value="{{ old('end_field_minute') }}">
                    </div>
                    <div class="two wide field">
                        <input class="second" name="end_field_second" type="number" min="0" max="59"
                               placeholder="Second"
                               value="{{ old('end_field_second') }}">
                    </div>
                    <div class="four wide field">
                        <div class="ui disabled input">
                            <input class="end_time_parsed" value="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="field">
                <label>Language</label>
                <div class="ui multiple selection dropdown language">
                    <input name="language" type="hidden">
                    <i class="dropdown icon"></i>
                    <div class="default text">No language selected</div>
                    <div class="menu">
                        @php
                            $languages = \Judgement\Language::all();
                        @endphp
                        @foreach($languages as $language)
                            <div class="item" data-value="{{ $language->id }}">{{ $language->name }}</div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="field">
                <label>User Categories</label>
                <div class="ui multiple selection dropdown category">
                    <input name="category" type="hidden">
                    <i class="dropdown icon"></i>
                    <div class="default text">Ignore to allow all categories</div>
                    <div class="menu">
                        @php
                            $categories = \Judgement\Category::all();
                        @endphp
                        @foreach($categories as $category)
                            <div class="item" data-value="{{ $category->id }}">{{ $category->name }}</div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="field">
                <label>Allowed user e-mail address (or group leader e-mail address)</label>
                <div class="ui fluid multiple search selection dropdown allowed_user">
                    <input type="hidden" name="allowed_user">
                    <i class="dropdown icon"></i>
                    <div class="default text">Ignore to allow all user (Use comma to separate email addresses)</div>
                    <div class="menu">
                    </div>
                </div>
            </div>
            <div class="field">
                <label>Active</label>
                <div class="ui checkbox">
                    <input type="checkbox" name="active">
                    <label>Active this contest immediately?</label>
                </div>
            </div>
            <div class="field">
                <label>
                    Announcement<br/>
                    <a target="_blank" href="https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet">Markdown
                        Cheatsheet</a>
                </label>
                <textarea name="announcement" rows="10">{{ old('statement') }}</textarea>
            </div>
            <button type="submit" class="ui primary submit button">Add</button>
            <a href="{{ url('/admin/contests') }}" class="ui button">Cancel</a>

            <div class="ui error message">
                <ul class="list">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </form>
    </div>
@endsection
