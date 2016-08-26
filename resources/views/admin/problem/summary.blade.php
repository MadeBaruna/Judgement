@extends('admin.index')

@section('title', $problem->name)

@section('active_problems', 'active')

@section('admin_breadcrumb')
    <a href="{{ url('/admin/problems/edit/' . $problem->id) }}"
       class="ui right floated labeled icon button delete_problem">
        <i class="edit icon"></i>
        Edit Problem
    </a>

    <div class="ui breadcrumb">
        <h1>
            Problem Summary
        </h1>
        <div class="section">
            <i class="home icon"></i>
            Dashboard
        </div>
        <i class="right chevron icon divider"></i>
        <a href="{{ url('/admin/problems') }}" class="section">
            <i class="cube icon"></i>
            Problems
        </a>
        <i class="right chevron icon divider"></i>
        <div class="section">
            {{ $problem->name }}
        </div>
    </div>
@endsection

@section('admin')
    <div class="problems">
        <div class="markdown-body">
            <h1 class="title">{{ $problem->name }}</h1>
            <table class="rules">
                <tr>
                    <td>Time Limit</td>
                    <td>{{ $problem->time_limit == 0 ? 'No Limit' : $problem->time_limit . ' Second' }}</td>
                </tr>
                <tr>
                    <td>Memory Limit</td>
                    <td>{{ $problem->memory_limit == 0 ? 'No Limit' :
                    ($problem->memory_limit >= 1000 ? $problem->memory_limit/1000 . ' MB' :
                    $problem->memory_limit . ' KB') }}
                    </td>
                </tr>
            </table>
            @markdown($problem->statement)
        </div>
@endsection
