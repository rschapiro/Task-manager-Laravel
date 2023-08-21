@extends('tasks.layout')

@section('content')

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
            <form action="{{ route('task.complete', $task->id) }}" method="POST">
                @csrf
                <input type="checkbox" {{ $task->completed ? 'checked disabled' : '' }}>
                <button type="submit" class="btn btn-success">Complete</button>
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