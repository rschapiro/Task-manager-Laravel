@extends('tasks.layout')

@section('content')

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/">My Task Manager</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <!-- Other navigation links here -->
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('task.index') }}">My Tasks</a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link">Logout</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<div class="row">
    <div class="col-lg-12">
        <div class="pull-left">
            <h2>Tasks</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('task.create') }}">Add New Task</a>
        </div>
    </div>
</div>

@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
@endif

<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Description</th>
        <th width="280px">Action</th>
        <th>Status</th>
    </tr>
    @if (count($tasks) > 0)
    @foreach ($tasks as $task)
    <tr>
        <td>{{ $task->id }}</td>
        <td>{{ $task->title }}</td>
        <td>{{ $task->description }}</td>
        <td>
            <form action="{{ route('task.destroy', $task->id) }}" method="POST">
                {{-- <a class="btn btn-info" href="{{ route('task.show', $task->id) }}">Show</a> --}}
                <a class="btn btn-primary" href="{{ route('task.edit', $task->id) }}">Edit</a>
                @csrf
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </td>
        <td>
            {{ $task->completed ? 'Completed' : 'Not Completed' }}
            <form action="{{ route('task.complete', $task->id) }}" method="POST">
                @csrf
                <input type="hidden" name="is_completed" value="{{ $task->completed }}">
                <button type="submit" class="btn btn-{{ $task->completed ? 'success' : 'warning' }}">Set status</button>
            </form>
        </td>
    </tr>
    @endforeach
    @else
    <tr>
        <td colspan="6">
            No data found...
        </td>
    </tr>
    @endif
</table>

{!! $tasks->links() !!}

@endsection