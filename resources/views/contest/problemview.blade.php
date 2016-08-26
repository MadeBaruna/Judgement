@extends('contest.index')

@section('active_problems', 'active')

@section('box')
    <div class="ui container">
        <div class="ui two column stackable grid">
            <div class="four wide column">
                <div class="ui vertical pointing fluid menu">
                    <a href='{{ url('/contest/' . $contest->id) }}' class="item @yield('active_announcement')">
                        <i class="bullhorn icon"></i>
                        Announcement
                    </a>
                </div>
                <div class="ui vertical pointing fluid menu problem_list">
                    <div class="item">
                        <i class="cube icon"></i>
                        <h4 class="header">Problems</h4>
                    </div>

                    @foreach($problems as $problem)
                        <a href='{{ url('/contest/' . $contest->id . '/problem/' . $problem->id) }}'
                           class="item
                           <?php
                           if (isset($currentProblem)) {
                               echo $currentProblem->id == $problem->id ? 'active' : '';
                           }
                           ?>">
                            {{ $problem->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="twelve wide column">
                <div class="ui top attached segment">
                    <div class="ui large teal label countdown" data-tooltip="Time Remaining"
                         data-position="left center">
                        <i class="clock icon"></i>
                        <span>{{ $contest->end_time }}</span>
                    </div>
                    @yield('contest_breadcrumb')
                </div>
                @yield('contest_content')
            </div>
        </div>
    </div>
@endsection
