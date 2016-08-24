@extends('contest.index')

@section('title', $contest->name)

@section('active_announcement', 'active')

@section('contest_breadcrumb')
    <div class="ui breadcrumb">
        <h1>
            Announcement
        </h1>
        <div class="section">
            <i class="home icon"></i>
        </div>
        <i class="right chevron icon divider"></i>
        <div class="section">
            <i class="cubes icon"></i>
            {{ $contest->name }}
        </div>
    </div>
@endsection

@section('contest_content')
    <div class="ui bottom attached segment">
        <div class="announcement">
            <div class="markdown-body">
                @markdown($contest->announcement)
            </div>
        </div>
    </div>
@endsection
