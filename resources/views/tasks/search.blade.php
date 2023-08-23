@extends('layouts.master')

@section('content')

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
            <form action="{{ route('task.setStatus', $task->id) }}" method="POST">
                @csrf
                <input type="hidden" name="is_completed" value="{{ $task->completed }}">
                {{-- <input type="hidden" name="user_id" value="{{ $task->completedBy }}"> --}}
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