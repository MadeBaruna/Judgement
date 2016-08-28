@extends('contest.index')

@section('title', 'Scoreboard')

@section('active_submission', 'active')

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
                    Scoreboard
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
                    <i class="list icon"></i>
                    Submissions
                </div>
            </div>
        </div>
        <div class="ui bottom attached segment">
            <table class="ui compact selectable table scoreboard">
                <thead>
                <tr>
                    <th>ID</th>
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
                                <a href="{{ url('/contest/' . $contest->id . '/submission/' . $submission->id) }}"
                                   class="compact ui icon button"><i class="magnify icon"></i></a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
