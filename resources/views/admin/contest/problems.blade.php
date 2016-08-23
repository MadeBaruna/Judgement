@extends('admin.index')

@section('title', $contest->name)

@section('active_contests', 'active')

@section('admin_breadcrumb')
    <div class="ui breadcrumb">
        <h1>
            Contest Problems
        </h1>
        <div class="section">
            <i class="home icon"></i>
            Dashboard
        </div>
        <i class="right chevron icon divider"></i>
        <a href="{{ url('/admin/contests') }}" class="section">
            <i class="cubes icon"></i>
            Contests
        </a>
        <i class="right chevron icon divider"></i>
        <a href="{{ url('/admin/contest/' . $contest->id) }}" class="section">
            {{ $contest->name }}
        </a>
        <i class="right chevron icon divider"></i>
        <div class="section">
            <i class="cube icon"></i>
            Problems
        </div>
    </div>
@endsection

@section('admin')
    <div class="testcases">
        <div class="ui top attached secondary segment">
            <h3>Add Problem</h3>
        </div>
        <div class="ui bottom attached segment">
            <form class="ui form {{ count($errors->all()) > 0 ? 'error' : '' }}" method="POST"
                  action="{{ url('/admin/contest/' . $contest->id . '/problems/add') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="fields">
                    <div class="twelve wide field {{ $errors->has('contest') ? 'error' : '' }}">
                        <div class="ui selection dropdown type">
                            <input type="hidden" name="contest" value="{{ old('contest') }}">
                            <i class="dropdown icon"></i>
                            <div class="default text">Select A Problem</div>
                            <div class="menu">
                                @foreach($allproblems as $allproblem)
                                    <div class="item" data-value="{{ $allproblem->id }}">
                                        {{ $allproblem->name }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="four wide field">
                        <button class="ui green labeled icon fluid button" type="submit">
                            <i class="add icon"></i>
                            Add Problem
                        </button>
                    </div>
                </div>
                <div class="ui error message">
                    <ul class="list">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </form>
        </div>
        <table class="ui selectable compact table table_list">
            <thead>
            <tr>
                <th class="collapsing">
                    ID
                </th>
                <th>
                    Problem Name
                </th>
                <th>
                    Problem Author
                </th>
                <th class="center aligned">
                    Time Limit
                </th>
                <th class="center aligned">
                    Memory Limit
                </th>
                <th class="collapsing"></th>
            </tr>
            </thead>
            <tbody>
            @php($no = 0)
            @foreach($problems as $problem)
                @php($no++)
                <tr>
                    <td class="center aligned table_list_id">{{ $problem->id }}</td>
                    <td>{{ $problem->name }}</td>
                    <td>{{ Judgement\User::find($problem->author_id)->first()->name }}</td>
                    <td class="center aligned">{{ $problem->time_limit }}</td>
                    <td class="center aligned">{{ $problem->memory_limit }}</td>
                    <td>
                        <div class="ui icon buttons">
                            <a href="{{ url('admin/problem/' . $problem->id) }}" class="ui icon button"
                               data-tooltip="Summary">
                                <i class="info icon"></i>
                            </a>
                            <a href="{{ url('admin/problems/edit/' . $problem->id) }}" class="ui button"
                               data-tooltip="Edit">
                                <i class="edit icon"></i>
                            </a>
                            <a href="{{ url('admin/problem/' . $problem->id . '/testcases') }}" class="ui button"
                               data-tooltip="Testcase">
                                <i class="book icon"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
            @if(count($problems) == 0)
                <tr>
                    <td colspan="6">
                        No problem for this contest yet
                    </td>
                </tr>
            @endif
            </tbody>
            @if(count($problems) != 0)
                <tfoot>
                <tr>
                    <th colspan="6">
                        <form method="POST" action="{{ url('/admin/contest/' . $contest->id . '/problems/delete') }}">
                            {{ csrf_field() }}
                            <input class="table_list_input" name="problem" type="hidden">
                            <button class="ui right floated red labeled icon button">
                                <i class="trash icon"></i>
                                Delete Selected
                            </button>
                        </form>
                    </th>
                </tr>
                </tfoot>
            @endif
        </table>
    </div>
@endsection
