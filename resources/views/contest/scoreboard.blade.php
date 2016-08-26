@extends('contest.index')

@section('title', 'Scoreboard')

@section('active_scoreboard', 'active')

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
                    Scoreboard
                </div>
            </div>
        </div>
        <div class="ui bottom attached segment">
            <table class="ui celled structured striped compact table scoreboard">
                <thead>
                <tr>
                    <th class="collapsing center aligned" rowspan="2">Rank</th>
                    <th rowspan="2">{{ $type == 'individual' ? 'Name' : 'Group Name' }}</th>
                    <th class="center aligned" rowspan="2">Total</th>
                    <th class="center aligned" colspan="{{ $problem_count }}">Problem</th>
                </tr>
                <tr>
                    @for($i=1; $i<=$problem_count; $i++)
                        <th class="center aligned">{{ $i }}</th>
                    @endfor
                </tr>
                </thead>
                <tbody>
                @php($rank=0)
                @foreach($score_id as $key => $id)
                    <tr>
                        <td class="center aligned">
                            {{ ++$rank }}
                        </td>
                        <td>
                            @php
                                if($type == 'individual') $u = Judgement\User::find($id);
                                else $u = Judgement\Group::find($id);
                            @endphp
                            <img class="ui avatar image" src="{{ $u->picture() }}">
                            {{ $u->name }}
                        </td>
                        <td class="center aligned">
                            @if(isset($score_total[$key]))
                                <strong>{{ $score_total[$key] }}</strong><br/>
                                {{ $score_penalty[$key] }}
                            @else
                                <strong>0</strong><br/>-
                            @endif
                        </td>
                        @for($i=0; $i < $problem_count; $i++)
                            @if(isset($score_problem[$key][$i]))
                                <td class="center aligned score {{ $score_problem[$key][$i] == 1 ? 'positive' : ($score_problem[$key][$i] == 0 ? 'negative' : '')}}">
                                    <strong>{{ $score_problem[$key][$i] }}<br/></strong>
                                    {{ $score_problem_penalty[$key][$i] }}
                                </td>
                            @else
                                <td class="center aligned score">
                                    -
                                </td>
                            @endif
                        @endfor
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
