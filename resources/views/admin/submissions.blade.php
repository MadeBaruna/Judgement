@extends('admin.contest')

@section('title', 'Submissions')

@section('active_submissions', 'active')

@section('div')
    <div class="ui top attached segment">
        <div class="ui large teal label countdown" data-tooltip="Time Remaining"
             data-position="left center">
            <i class="clock icon"></i>
            <span>{{ $contest->end_time }}</span>
        </div>
        <div class="ui">
            <h1>
                Submissions
            </h1>
            <p>{{ $contest->name }}</p>
        </div>
    </div>
    <div class="ui bottom attached segment">
        <div class="ui small form">
            <div class="three fields">
                <div class="seven wide field">
                    <div class="ui fluid search selection dropdown problem_list">
                        <input type="hidden" class="problem" value="{{ $pid }}">
                        <i class="dropdown icon"></i>
                        <div class="default text">Show All Problems</div>
                        <div class="menu">
                            <div class="item" data-value="0">Show All Problems</div>
                            @foreach($problems as $problem)
                                <div class="item" data-value="{{ $problem->id }}">{{ $problem->name }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="seven wide field">
                    <div class="ui fluid search selection dropdown user_list">
                        <input type="hidden" class="userlisting" value="{{ $uid }}">
                        <i class="dropdown icon"></i>
                        <div class="default text">Show All Users</div>
                        <div class="menu">
                            <div class="item" data-value="0">Show All Users</div>
                            @foreach($users as $user)
                                <div class="item" data-value="{{ $user->id }}">{{ $user->name }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="two wide field">
                    <a href="" class="ui fluid button search_sub">Search</a>
                </div>
            </div>
        </div>
        <table class="ui compact selectable table scoreboard">
            <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Problem</th>
                <th>Language</th>
                <th>Score</th>
                <th>Verdict</th>
                <th>Time</th>
                <th class="collapsing center aligned"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($submissions as $submission)
                <tr>
                    <td>
                        {{ $submission->id }}
                    </td>
                    <td>
                        {{ $submission->user->name }}
                    </td>
                    <td>
                        {{ Judgement\Problem::find($submission->problem_id)->name }}
                    </td>
                    <td>
                        {{ Judgement\Language::find($submission->language_id)->name }}
                    </td>
                    <td>
                        {{ $submission->score }}
                    </td>
                    <td>
                        <?php
                        $verdict = $submission->status;
                        switch ($verdict) {
                            case 'Pending':
                                echo '<span class="ui grey label">Pending</span>';
                                break;
                            case 'AC':
                                echo '<span class="ui green label">Accepted</span>';
                                break;
                            case 'WA':
                                echo '<span class="ui red label">Wrong Answer</span>';
                                break;
                            case 'RE':
                                echo '<span class="ui red label">Runtime Error</span>';
                                break;
                            case 'SG':
                                echo '<span class="ui red label">Runtime Error</span>';
                                break;
                            case 'TO':
                                echo '<span class="ui red label">Timed Out</span>';
                                break;
                            case 'CE':
                                echo '<span class="ui black label">Compile Error</span>';
                                break;
                            case 'XX':
                                echo '<span class="ui black label">Compile Error</span>';
                                break;
                        }
                        ?>
                    </td>
                    <td>
                        {{ \Carbon\Carbon::parse($submission->submitted_at)->diffForHumans() }}
                    </td>
                    <td>
                        <div class="ui icon buttons">
                            <a href="{{ url('/admin/submission/' . $contest->id . '/' . $submission->id) }}"
                               class="compact ui icon button"><i class="magnify icon"></i></a>
                        </div>
                    </td>
                </tr>
            </tbody>
            @endforeach
            @if($submissions->total() != 0)
                <tfoot>
                <tr>
                    <th colspan="8">
                        <div class="ui right floated pagination menu">
                            @include('layouts.pagination', ['page' => $submissions])
                        </div>
                    </th>
                </tr>
                </tfoot>
            @else
                <tfoot>
                <tr>
                    <th colspan="7">
                        No submission yet
                    </th>
                </tr>
                </tfoot>
            @endif
        </table>
    </div>
@endsection
