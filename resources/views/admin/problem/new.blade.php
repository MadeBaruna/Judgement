@extends('admin.index')

@section('title', 'New Problem')

@section('active_problems', 'active')

@section('admin_breadcrumb')
    <div class="ui breadcrumb">
        <h1>
            New Contest
        </h1>
        <div class="section">
            <i class="home icon"></i>
            Dashboard
        </div>
        <i class="right chevron icon divider"></i>
        <a href="{{ url('/admin/contests') }}" class="section">
            <i class="cube icon"></i>
            Problems
        </a>
        <i class="right chevron icon divider"></i>
        <div class="section">
            New
        </div>
    </div>
@endsection

@section('admin')
    <div class="problems">
        <form class="ui form {{ count($errors->all()) > 0 ? 'error' : '' }}"
              method="POST" action="{{ url('/admin/problems/new') }}">
            {{ csrf_field() }}
            <div class="field {{ $errors->has('problem_name') ? 'error' : '' }}">
                <label>Problem name</label>
                <input type="text" name="problem_name" placeholder="Problem name" value="{{ old('problem_name') }}">
            </div>
            <div class="fields">
                <div class="field">
                    <label>Time limit</label>
                    <div class="ui right labeled input">
                        <input type="number" name="time_limit" placeholder="No time limit" value="{{ old('time_limit') }}">
                        <div class="ui basic label">
                            Second
                        </div>
                    </div>
                </div>
                <div class="field">
                    <label>Memory limit</label>
                    <div class="ui right labeled input">
                        <input type="number" name="memory_limit" placeholder="No memory limit" value="{{ old('memory_limit') }}">
                        <div class="ui basic label">
                            KB
                        </div>
                    </div>
                </div>
            </div>
            <div class="field">
                <label>
                    Problem statement<br/>
                    <a target="_blank" href="https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet">Markdown Cheatsheet</a>
                </label>
                <textarea name="statement" rows="30">@if(old('statement') != ''){{ old('statement') }} @else## Description
problem description

## Input Format
input description

## Output Format
output description

## Sample Input
```
1 2 3
```
## Sample Output
```
6
```
## Explanation
explanation

## Constraints
- $$ 1 <= T < 2 $$ @endif</textarea>
            </div>
            <button type="submit" class="ui primary submit button">Add</button>
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
@endsection
