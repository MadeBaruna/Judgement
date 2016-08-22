@extends('admin.index')

@section('title', 'Edit Contests')

@section('active_contests', 'active')

@section('admin_breadcrumb')
    <button class="ui right floated red labeled icon button delete_contest">
        <i class="trash icon"></i>
        Delete Contest
    </button>

    <div class="ui breadcrumb">
        <h1>
            Edit Contest
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
        <a href="{{ url('/admin/contest/' . $contest->id) }}" class="section">
            {{ $contest->name }}
        </a>
        <i class="right chevron icon divider"></i>
        <div class="section">
            Edit
        </div>
    </div>
@endsection

@section('admin')
    <div class="contests">
        <form class="ui form {{ count($errors->all()) > 0 ? 'error' : '' }}"
              method="POST" action="{{ url('/admin/contests/edit/' . $contest->id) }}">
            {{ csrf_field() }}
            <div class="field {{ $errors->has('contest_name') ? 'error' : '' }}">
                <label>Contest name</label>
                <input type="text" name="contest_name" placeholder="Contest name" value="{{ $contest->name }}">
            </div>
            <div class="field {{ $errors->has('type') ? 'error' : '' }}">
                <label>Contest type</label>
                <div class="ui selection dropdown type">
                    <input type="hidden" name="type" value="{{ $contest->type }}">
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
            @php($startDateTime = \Carbon\Carbon::parse($contest->start_time))
            <input class="start_time_input" type="hidden" name="start_time">
            <div class="field start_date {{ $errors->has('start_time') ? 'error' : '' }}">
                <label>Start time</label>
                <div class="inline fields">
                    <div class="two wide field">
                        <input class="date" name="start_field_date" type="number" min="1" max="31" placeholder="Date"
                               value="{{ $startDateTime->day }}">
                    </div>
                    <div class="two wide field">
                        <input class="month" name="start_field_month" type="number" min="1" max="12" placeholder="Month"
                               value="{{ $startDateTime->month }}">
                    </div>
                    <div class="two wide field">
                        <input class="year" name="start_field_year" type="number" min="1" placeholder="Year"
                               value="{{ $startDateTime->year }}">
                    </div>
                    <div class="one wide field"></div>
                    <div class="two wide field">
                        <input class="hour" name="start_field_hour" type="number" min="0" max="23" placeholder="Hour"
                               value="{{ $startDateTime->hour }}">
                    </div>
                    <div class="two wide field">
                        <input class="minute" name="start_field_minute" type="number" min="0" max="59"
                               placeholder="Minute"
                               value="{{ $startDateTime->minute }}">
                    </div>
                    <div class="two wide field">
                        <input class="second" name="start_field_second" type="number" min="0" max="59"
                               placeholder="Second"
                               value="{{ $startDateTime->second }}">
                    </div>
                    <div class="four wide field">
                        <div class="ui disabled input">
                            <input class="start_time_parsed" value="">
                        </div>
                    </div>
                </div>
            </div>
            @php($endDateTime = \Carbon\Carbon::parse($contest->end_time))
            <input class="end_time_input" type="hidden" name="end_time">
            <div class="field end_date {{ $errors->has('end_time') ? 'error' : '' }}">
                <label>End time</label>
                <div class="inline fields">
                    <div class="two wide field">
                        <input class="date" name="end_field_date" type="number" min="1" max="31" placeholder="Date"
                               value="{{ $endDateTime->day }}">
                    </div>
                    <div class="two wide field">
                        <input class="month" name="end_field_month" type="number" min="1" max="12" placeholder="Month"
                               value="{{ $endDateTime->month }}">
                    </div>
                    <div class="two wide field">
                        <input class="year" name="end_field_year" type="number" min="1" placeholder="Year"
                               value="{{ $endDateTime->year }}">
                    </div>
                    <div class="one wide field"></div>
                    <div class="two wide field">
                        <input class="hour" name="end_field_hour" type="number" min="0" max="23" placeholder="Hour"
                               value="{{ $endDateTime->hour }}">
                    </div>
                    <div class="two wide field">
                        <input class="minute" name="end_field_minute" type="number" min="0" max="59"
                               placeholder="Minute"
                               value="{{ $endDateTime->minute }}">
                    </div>
                    <div class="two wide field">
                        <input class="second" name="end_field_second" type="number" min="0" max="59"
                               placeholder="Second"
                               value="{{ $endDateTime->second }}">
                    </div>
                    <div class="four wide field">
                        <div class="ui disabled input">
                            <input class="end_time_parsed" value="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="field {{ $errors->has('language') ? 'error' : '' }}">
                <label>Language</label>
                <div class="ui multiple selection dropdown language">
                    <input name="language" type="hidden" value="{{ $languages }}">
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
                    <input name="category" type="hidden" value="{{ $categories }}">
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
                    <input type="hidden" name="allowed_user" value="{{ $allowed_users }}">
                    <i class="dropdown icon"></i>
                    <div class="default text">Ignore to allow all user (Use comma to separate email addresses)</div>
                    <div class="menu">
                    </div>
                </div>
            </div>
            <div class="field">
                <label>Active</label>
                <div class="ui checkbox">
                    @php($active = $contest->active == 1 ? 'checked' : '')
                    <input type="checkbox" name="active" {{ $active }}>
                    <label>Active this contest?</label>
                </div>
            </div>
            <button type="submit" class="ui primary submit button">Edit</button>
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

    <div class="ui small basic modal delete_contest_modal">
        <div class="ui icon header">
            <i class="trash icon"></i>
            Delete This Contest?
        </div>
        <div class="content">
            <p>Are you sure to delete contest {{ $contest->name }}? This action cannot be undone.</p>
        </div>
        <div class="actions">
            <form method="POST" action="{{ url('/admin/contests/delete/' . $contest->id) }}">
                {{ csrf_field() }}
                <div class="ui red basic cancel inverted button">
                    <i class="remove icon"></i>
                    Cancel
                </div>
                <button type="submit" class="ui green ok inverted button">
                    <i class="trash icon"></i>
                    Delete
                </button>
            </form>
        </div>
    </div>
@endsection
