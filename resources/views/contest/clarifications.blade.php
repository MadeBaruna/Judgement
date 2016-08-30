@extends('contest.index')

@section('title', 'Clarifications')

@section('active_clarifications', 'active')

@section('content')
    <div class="ui container">
        <div class="ui top attached segment">
            <div class="ui large teal label countdown" data-tooltip="Time Remaining"
                 data-position="left center">
                <i class="clock icon"></i>
                <span>{{ $contest->end_time }}</span>
            </div>
            <div class="ui breadcrumb">
                <h1>
                    Clarifications
                </h1>
                <div class="section">
                    <i class="home icon"></i>
                </div>
                <i class="right chevron icon divider"></i>
                <a href="{{ url('/contest/' . $contest->id) }}" class="section">
                    <i class="cubes icon"></i>
                    {{ $contest->name }}
                </a>
                <i class="right chevron icon divider"></i>
                <div class="section">
                    <i class="mail icon"></i>
                    Clarifications
                </div>
            </div>
        </div>
        <div class="ui bottom attached segment">
            <div class="ui top attached secondary segment">
                <h3>Ask For Clarification</h3>
            </div>
            <div class="ui bottom attached segment">
                <form class="ui form {{ count($errors->all()) > 0 ? 'error' : '' }}" method="POST"
                      action="{{ url('/contest/' . $contest->id . '/clarifications/new') }}"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="field {{ $errors->has('title') ? 'error' : '' }}">
                        <label>Title</label>
                        <input type="text" name="title" placeholder="Title" value="{{ old('title') }}">
                    </div>
                    <div class="field {{ $errors->has('problem') ? 'error' : '' }}">
                        <label>Problem</label>
                        <div class="ui selection dropdown type">
                            <input type="hidden" name="problem" value="{{ old('problem') }}">
                            <i class="dropdown icon"></i>
                            <div class="default text">Select The Problem</div>
                            <div class="menu">
                                @foreach($allproblems as $allproblem)
                                    <div class="item" data-value="{{ $allproblem->id }}">
                                        {{ $allproblem->name }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="field {{ $errors->has('question') ? 'error' : '' }}">
                        <label>Question</label>
                        <textarea type="text" name="question" rows="2">{{ old('question') }}</textarea>
                    </div>
                    <button class="ui button" type="submit">Submit</button>
                    <div class="ui error message">
                        <ul class="list">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </form>
            </div>
            <table class="ui compact selectable table scoreboard">
                <thead>
                <tr>
                    <th>By</th>
                    <th>Title</th>
                    <th>Problem Name</th>
                    <th></th>
                    <th class="collapsing center aligned"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($clarifications as $clarification)
                    <tr>
                        <td>
                            <img class="ui avatar image" src="{{ $clarification->user->picture() }}"/>
                            {{ $clarification->user->name }}
                        </td>
                        <td>
                            {{ $clarification->title }}
                        </td>
                        <td>
                            {{ Judgement\Problem::find($clarification->problem_id)->name }}
                        </td>
                        <td>
                            @if($clarification->is_answered)
                                <span class="ui green label">Answered</span>
                            @endif
                        </td>
                        <td>
                            <div class="ui icon buttons">
                                <button class="compact ui icon button clarification" data-contest="{{ $contest->id }}"
                                        data-clarification="{{ $clarification->id }}">
                                    <i class="magnify icon"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
                @endforeach
                @if($clarifications->total() != 0)
                    <tfoot>
                    <tr>
                        <th colspan="7">
                            <div class="ui right floated pagination menu">
                                @include('layouts.pagination', ['page' => $clarifications])
                            </div>
                        </th>
                    </tr>
                    </tfoot>
                @else
                    <tfoot>
                    <tr>
                        <th colspan="7">
                            No clarification yet
                        </th>
                    </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </div>

    <div class="ui small modal clarification_modal">
        <div class="header clarification_title">
            Clarification
        </div>
        <div class="content">
            <table class="ui definition table">
                <tr>
                    <td class="collapsing">Problem</td>
                    <td class="problem"></td>
                </tr>
                <tr>
                    <td class="collapsing">Question</td>
                    <td class="question"></td>
                </tr>
                <tr>
                    <td class="collapsing">Answer</td>
                    <td class="answer"></td>
                </tr>
            </table>
        </div>
        <div class="actions">
            <div class="ui button approve">OK</div>
        </div>
    </div>
@endsection
