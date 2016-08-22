@extends('admin.index')

@section('title', 'Problems')

@section('active_problems', 'active')

@section('admin_breadcrumb')
    <a href="{{ url('/admin/problems/new') }}" class="ui right floated green labeled icon button">
        <i class="add icon"></i>
        New Problem
    </a>

    <div class="ui breadcrumb">
        <h1>
            Problems
        </h1>
        <div class="section">
            <i class="home icon"></i>
            Dashboard
        </div>
        <i class="right chevron icon divider"></i>
        <div class="section">
            <i class="cube icon"></i>
            Problems
        </div>
    </div>
@endsection

@section('admin')
    <div class="contests">
        <table class="ui selectable compact table">
            <thead>
            <tr>
                <th class="collapsing">
                    No
                </th>
                <th>
                    Problem Name
                </th>
                <th>
                    Author
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
            @php($no = 0 + ($problems->currentPage()-1)*15)
            @foreach($problems as $problem)
                <tr>
                    @php($no++)
                    <td class="center aligned">{{ $no }}</td>
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
                        No problem yet
                    </td>
                </tr>
            @endif
            </tbody>
            @if($problems->total() != 0)
                <tfoot>
                <tr>
                    <th colspan="6">
                        <div class="ui right floated pagination menu">
                            @include('layouts.pagination', ['page' => $problems])
                        </div>
                    </th>
                </tr>
                </tfoot>
            @endif
        </table>
    </div>
@endsection
