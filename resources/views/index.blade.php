@extends('layouts.index')

@section('title', 'Home')

@section('content')
    @php
        $type = Auth::check() ? Auth::user()->type : 'none';
    @endphp
    <div class="ui container">
        @if($type == 'admin')
            <h1>Contest List</h1>
            <p>You can manage this on your admin dashboard.</p>
        @else
            <h1>Available Contest</h1>
            <p>You can join any contest available below.</p>
        @endif
        @if($errors->any())
            <div class="ui error message">
                <div class="header">{{ $errors->first('title') }}</div>
                <p>{{ $errors->first('description') }}</p>
            </div>
        @endif
        <table class="ui selectable table">
            <thead>
            <tr>
                <th class="collapsing">
                    No
                </th>
                <th>
                    Contest Name
                </th>
                <th class="center aligned ">
                    Category
                </th>
                <th>
                    Start Time
                </th>
                <th>
                    End Time
                </th>
                <th class="center aligned ">
                    Status
                </th>
                <th class="collapsing"></th>
            </tr>
            </thead>
            <tbody>
            @php($no = 0)
            @foreach($contests as $contest)
                <tr>
                    @php($no++)
                    <td class="center aligned">{{ $no }}</td>
                    <td>{{ $contest->name }}</td>
                    <td class="center aligned">{{ ucfirst($contest->type) }}</td>
                    @php
                        $startDateTime = Carbon\Carbon::parse($contest->start_time);
                        $startDate = $startDateTime->formatLocalized('%a %d %b %Y');
                        $startTime = $startDateTime->formatLocalized('%T');

                        $endDateTime = Carbon\Carbon::parse($contest->end_time);
                        $endDate = Carbon\Carbon::parse($contest->end_time)->formatLocalized('%a %d %b %Y');
                        $endTime = Carbon\Carbon::parse($contest->end_time)->formatLocalized('%T');
                    @endphp

                    <span type="hidden" class="start_time_index" data-id="{{ $contest->id }}"
                          data-datetime="{{ $startDateTime->toDateTimeString() }}"></span>

                    <td class="collapsing">{{ $startDate }}<br/>{{ $startTime }}</td>
                    <td class="collapsing">{{ $endDate }}<br/>{{ $endTime }}</td>
                    <td class="center aligned">
                        @if($contest->active == 0)
                            <div class="ui black label">Not Active</div>
                        @elseif($contest->status == 'Not Started')
                            <div class="ui gray label">{{ $contest->status }}</div>
                        @elseif($contest->status == 'Started')
                            <div class="ui green label">{{ $contest->status }}</div>
                        @else
                            <div class="ui red label">{{ $contest->status }}</div>
                        @endif
                    </td>
                    @if($type != 'admin')
                        <td class="collapsing">
                            <a href="{{ url('/contest/' . $contest->id) }}"
                               class="ui labeled icon {{ $contest->status == 'Not Started' ? 'teal' : 'primary' }} fluid button">
                                <i class="sign in icon"></i>
                                @if($contest->status == 'Not Started')
                                    <label class="time_button" data-id="{{ $contest->id }}">Not Started</label>
                                @else
                                    <label>Enter</label>
                                @endif
                            </a>
                        </td>
                    @else
                        <td class="collapsing">
                            <a href="{{ url('admin/scoreboard/' . $contest->id) }}"
                               class="ui labeled icon {{ $contest->status == 'Not Started' ? 'teal' : 'primary' }} fluid button">
                                <i class="sign in icon"></i>
                                <label>Enter</label>
                            </a>
                        </td>
                    @endif
                </tr>
            @endforeach
            @if(count($contests) == 0)
                <tr>
                    <td colspan="7">
                        No contest available for you.
                    </td>
                </tr>
            @endif
            </tbody>
        </table>

            @if($type == 'admin')
                <h1>Sandbox Status</h1>
                <table class="ui celled table">
                    @php($counter=0)
                    @foreach(Judgement\Sandbox::all() as $sandbox)
                        @if($counter%10==0)
                            <tr>
                                @endif
                                @if($sandbox->is_available == 1)
                                    <td class="center aligned positive collapsing">Idle</td>
                                @else
                                    <td class="center aligned negative collapsing">Working
                                        #{{ $sandbox->submission_id }}</td>
                                @endif
                                @php($counter++)
                                @if($counter%10==0)
                            </tr>
                        @endif
                    @endforeach
                </table>
            @endif
    </div>
@endsection
