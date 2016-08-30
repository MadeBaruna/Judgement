@extends('admin.contest')

@section('title', 'Home')

@section('active_clarifications', 'active')

@section('div')
    <div class="ui top attached segment">
        <div class="ui large teal label countdown" data-tooltip="Time Remaining"
             data-position="left center">
            <i class="clock icon"></i>
            <span>{{ $contest->end_time }}</span>
        </div>
        <div class="ui">
            <h1>
                Clarifications
            </h1>
            <p>{{ $contest->name }}</p>
        </div>
    </div>
    <div class="ui bottom attached segment">
        @if($errors->any())
            <div class="ui error message">
                <ul class="list">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
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

    <div class="ui small modal clarification_admin_modal">
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
                    <td class="answer">
                        <p class="old_answer"></p>
                        <form class="ui form" method="POST" action="">
                            {{ csrf_field() }}
                            <textarea name="answer" rows="3"></textarea>
                    </td>
                </tr>
            </table>
        </div>
        <div class="actions">
            <div class="ui button approve">Close</div>
            <button type="submit" class="ui green button">Answer</button>
        </div>
        </form>
    </div>
@endsection
