@extends('admin.index')

@section('title', 'Problems')

@section('active_problems', 'active')

@section('admin_breadcrumb')
    <form method="POST" action="{{ url('/admin/problem/' . $problem->id . '/testcases/delete/') }}">
        {{ csrf_field() }}
        <input class="testcase_input" name="testcase" type="hidden" value="{{ $testcase->id }}">
        <button type="submit" class="ui right floated red labeled icon button">
            <i class="trash icon"></i>
            Delete Testcase
        </button>
    </form>

    <div class="ui breadcrumb">
        <h1>
            Testcase
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
        <i class="right chevron icon divider"></i>
        <a href="{{ url('/admin/problem/' . $problem->id) }}" class="section">
            {{ $problem->name }}
        </a>
        <i class="right chevron icon divider"></i>
        <a href="{{ url('/admin/problem/' . $problem->id . '/testcases') }}" class="section">
            Testcases
        </a>
        <i class="right chevron icon divider"></i>
        <div href="" class="section">
            <i class="book icon"></i>
            ID:{{ $testcase->id }}
        </div>
    </div>
@endsection

@section('admin')
    <div class="contests">
        <div class="ui grid markdown-body">
            <div class="eight wide column">
                <h2>Input</h2>
                <pre><code>{{ $input }}</code></pre>
            </div>
            <div class="eight wide column">
                <h2>Output</h2>
                <pre><code>{{ $output }}</code></pre>
            </div>
        </div>
    </div>
@endsection
