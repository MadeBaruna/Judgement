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
                Submission #{{ $submission->id }}
            </h1>
            <p>{{ $contest->name }}</p>
        </div>
    </div>
    <div class="ui bottom attached segment">
        <table class="ui compact definition table">
            <tbody>
            <tr>
                <td>
                    Submission ID
                </td>
                <td>
                    {{ $submission->id }}
                </td>
            </tr>
            <tr>
                <td>
                    Submitter
                </td>
                <td>
                    {{ $submission->user->name }}
                </td>
            </tr>
            <tr>
                <td>
                    Contest
                </td>
                <td>
                    {{ $contest->name }}
                </td>
            </tr>
            <tr>
                <td>
                    Problem
                </td>
                <td>
                    {{ $problem->name }}
                </td>
            </tr>
            <tr>
                <td>
                    Language
                </td>
                <td>
                    {{ $language->name }}
                </td>
            </tr>
            <tr>
                <td>
                    Verdict
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
            </tr>
            <tr>
                <td>
                    Score
                </td>
                <td>
                    {{ $submission->score }}
                </td>
            </tr>
            <tr>
                <td>
                    Submit Time
                </td>
                <td>
                    {{ $submission->submitted_at }}
                </td>
            </tr>
            <tr>
                <td>
                    Source Code
                </td>
                <td class="markdown-body">
                    <pre><code class="source_code">{{ $code }}</code></pre>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection
