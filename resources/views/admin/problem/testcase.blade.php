@extends('admin.index')

@section('title', $problem->name)

@section('active_problems', 'active')

@section('admin_breadcrumb')
    <div class="ui breadcrumb">
        <h1>
            Testcases
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
            <i class="book icon"></i>
            Testcases
        </div>
    </div>
@endsection

@section('admin')
    <div class="testcases">
        <div class="ui top attached secondary segment">
            <h3>Add Testcase</h3>
        </div>
        <div class="ui bottom attached segment">
            <form class="ui form {{ count($errors->all()) > 0 ? 'error' : '' }}" method="POST"
                  action="{{ url('/admin/problem/' . $problem->id . '/testcases') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="fields">
                    <div class="six wide field {{ $errors->has('input_file') ? 'error' : '' }}">
                        <div class="ui labeled fluid input">
                            <div class="ui {{ $errors->has('input_file') ? 'red' : '' }} button label">
                                Input File
                            </div>
                            <input type="text" readonly class='loader active inline'>
                            <input type="file" name="input_file">
                        </div>
                    </div>
                    <div class="six wide field {{ $errors->has('output_file') ? 'error' : '' }}">
                        <div class="ui labeled fluid input">
                            <div class="ui {{ $errors->has('output_file') ? 'red' : '' }} button label">
                                Output File
                            </div>
                            <input type="text" readonly class='loader active inline'>
                            <input type="file" name="output_file">
                        </div>
                    </div>
                    <div class="four wide field">
                        <button class="ui green labeled icon fluid button" type="submit">
                            <i class="add icon"></i>
                            Add Testcase
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
                <th>
                    ID
                </th>
                <th>
                    Input Size
                </th>
                <th>
                    Output Size
                </th>
                <th class="collapsing"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($testcases as $testcase)
                <tr>
                    <td class="table_list_id">{{ $testcase->id }}</td>
                    <td>{{ $testcase->input_size }} bytes</td>
                    <td>{{ $testcase->output_size }} bytes</td>
                    <td>
                        <a href="testcase/{{ $testcase->id }}" class="compact ui label">
                            View
                        </a>
                    </td>
                </tr>
            @endforeach
            @if(count($testcases) == 0)
                <tr>
                    <td colspan="6">
                        No testcase yet
                    </td>
                </tr>
            @endif
            </tbody>
            @if(count($testcases) != 0)
                <tfoot>
                <tr>
                    <th colspan="4">
                        <form method="POST" action="{{ url('/admin/problem/' . $problem->id . '/testcases/delete/') }}">
                            {{ csrf_field() }}
                            <input class="table_list_input" name="testcase" type="hidden">
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
