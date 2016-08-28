@extends('contest.problemview')

@section('title', $contest->name)

@section('contest_breadcrumb')
    <div class="ui breadcrumb">
        <h1>
            {{ $currentProblem->name }}
        </h1>
        <div class="section">
            <i class="home icon"></i>
        </div>
        <i class="right chevron icon divider"></i>
        <div class="section">
            <i class="cubes icon"></i>
            {{ $contest->name }}
        </div>
        <i class="right chevron icon divider"></i>
        <div class="section">
            <i class="cube icon"></i>
            Problem
        </div>
        <i class="right chevron icon divider"></i>
        <div class="section">
            {{ $currentProblem->name }}
        </div>
    </div>
@endsection

@section('contest_content')
    <div class="ui attached segment">
        <div class="announcement">
            <div class="markdown-body">
                <div class="ui grey image large label">
                    Time Limit
                    <div class="detail">{{ $currentProblem->time_limit == 0 ? 'No Limit' : $currentProblem->time_limit . ' Second' }}</div>
                </div>
                <div class="ui grey image large label">
                    Memory Limit
                    <div class="detail">{{ $currentProblem->memory_limit == 0 ? 'No Limit' :
                    ($currentProblem->memory_limit >= 1000 ? $currentProblem->memory_limit/1000 . ' MB' :
                    $currentProblem->memory_limit . ' KB') }}</div>
                </div>
                @markdown($currentProblem->statement)
            </div>
        </div>
    </div>
    <div class="ui attached secondary segment">
        <h3>Submit Answer</h3>
    </div>
    <div class="ui bottom attached segment">
        <div class="ui inverted dimmer submit_loading">
            <div class="ui indeterminate small text loader">Judging...</div>
        </div>
        <form class="ui form {{ count($errors->all()) > 0 ? 'error' : '' }}" method="POST"
              action="{{ url('/contest/' . $contest->id . '/problem/' . $currentProblem->id . '/submit') }}"
              enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="three fields">
                <div class="eight wide field {{ $errors->has('source_code') ? 'error' : '' }}">
                    <div class="ui labeled fluid input">
                        <div class="ui {{ $errors->has('source_code') ? 'red' : '' }} button label">
                            Source Code
                        </div>
                        <input type="text" readonly class='loader active inline'>
                        <input type="file" name="input_file">
                    </div>
                </div>
                <div class="five wide field">
                    <div class="ui selection dropdown submit_source">
                        <input type="hidden" name="language" value="{{ old('language') }}">
                        <i class="dropdown icon"></i>
                        <div class="default text">Language</div>
                        <div class="menu">
                            @foreach($languages as $language)
                                <div class="item" data-value="{{ $language->id }}">
                                    {{ $language->name }}
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
                <div class="three wide field submit_source">
                    <button class="ui green labeled icon fluid button submit_problem" type="submit">
                        <i class="upload icon"></i>
                        Submit
                    </button>
                </div>
            </div>
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
