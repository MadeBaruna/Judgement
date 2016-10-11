@extends('admin.index')

@section('title', 'Contests')

@section('active_contests', 'active')

@section('admin_breadcrumb')
    <a href="{{ url('/admin/contests/new') }}" class="ui right floated green labeled icon button">
        <i class="add icon"></i>
        New Contest
    </a>

    <div class="ui breadcrumb">
        <h1>
            Contests
        </h1>
        <div class="section">
            <i class="home icon"></i>
            Dashboard
        </div>
        <i class="right chevron icon divider"></i>
        <div class="section">
            <i class="cubes icon"></i>
            Contests
        </div>
    </div>
@endsection

@section('admin')
    <div class="contests">
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
                    Type
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
                    <td>
                        <div class="ui icon buttons">
                            <a href="{{ url('/admin/contest/' . $contest->id) }}" class="ui icon button"
                               data-tooltip="Summary">
                                <i class="info icon"></i>
                            </a>
                            <a href="{{ url('/admin/contests/edit/' . $contest->id) }}" class="ui button"
                               data-tooltip="Edit">
                                <i class="edit icon"></i>
                            </a>
                            <a href="{{ url('/admin/contest/' . $contest->id . '/problems') }}" class="ui button"
                               data-tooltip="Problems">
                                <i class="cube icon"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
            @if(count($contests) == 0)
                <tr>
                    <td colspan="7">
                        No contest yet
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
@endsection
