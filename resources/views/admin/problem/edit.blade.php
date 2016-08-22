@extends('admin.index')

@section('title', 'Edit Problem')

@section('active_problems', 'active')

@section('admin_breadcrumb')
    <button class="ui right floated red labeled icon button delete_problem">
        <i class="trash icon"></i>
        Delete Problem
    </button>
    <div class="ui breadcrumb">
        <h1>
            Edit Contest
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
        <a href="{{ url('/admin/problem/' . $problem->id) }}" class="section">
            {{ $problem->name }}
        </a>
        <i class="right chevron icon divider"></i>
        <div class="section">
            Edit
        </div>
    </div>
@endsection

@section('admin')
    <div class="problems">
        <form class="ui form {{ count($errors->all()) > 0 ? 'error' : '' }}"
              method="POST" action="{{ url('/admin/problems/edit/' . $problem->id) }}">
            {{ csrf_field() }}
            <div class="field {{ $errors->has('problem_name') ? 'error' : '' }}">
                <label>Problem name</label>
                <input type="text" name="problem_name" placeholder="Problem name" value="{{ $problem->name }}">
            </div>
            <div class="fields">
                <div class="field">
                    <label>Time limit</label>
                    <div class="ui right labeled input">
                        <input type="number" name="time_limit" placeholder="No time limit"
                               value="{{ $problem->time_limit }}">
                        <div class="ui basic label">
                            Second
                        </div>
                    </div>
                </div>
                <div class="field">
                    <label>Memory limit</label>
                    <div class="ui right labeled input">
                        <input type="number" name="memory_limit" placeholder="No memory limit"
                               value="{{ $problem->memory_limit }}">
                        <div class="ui basic label">
                            KB
                        </div>
                    </div>
                </div>
            </div>
            <div class="field">
                <label>
                    Problem statement<br/>
                    <a target="_blank" href="https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet">Markdown
                        Cheatsheet</a>
                </label>
                <textarea name="statement" rows="30">{{ $problem->statement }}</textarea>
            </div>
            <button type="submit" class="ui primary submit button">Edit</button>
            <a href="{{ url('/admin/problems') }}" class="ui button">Cancel</a>

            <div class="ui error message">
                <ul class="list">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </form>
    </div>

    <div class="ui small basic modal delete_problem_modal">
        <div class="ui icon header">
            <i class="trash icon"></i>
            Delete This Problem?
        </div>
        <div class="content">
            <p>Are you sure to delete problem {{ $problem->name }}? All submissions to this problem will be deleted too.
                This action cannot be undone.</p>
        </div>
        <div class="actions">
            <form method="POST" action="{{ url('/admin/problems/delete/' . $problem->id) }}">
                {{ csrf_field() }}
                <div class="ui red basic cancel inverted button">
                    <i class="remove icon"></i>
                    Cancel
                </div>
                <button type="submit" class="ui green ok inverted button">
                    <i class="trash icon"></i>
                    Delete
                </button>
            </form>
        </div>
    </div>
@endsection
