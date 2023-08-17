<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Tasks</h1>
    <div>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Completed</th>
                <th>Edit</th>
            </tr>
            @if (count($tasks) > 0)            
            @foreach($tasks as $task)
                <tr>
                    <td>{{$task->id}}</td>
                    <td>{{$task->title}}</td>
                    <td>{{$task->description}}</td>
                    <td>{{$task->completed}}</td>
                    <td>
                        <a href="{{route('task.edit', $task->id)}}">Edit</a>
                    </td>
                    <td>
                        <form method="POST" action="{{ route('task.destroy', ['task' => $task]) }}">
                            @csrf
                            <input type="submit" value="Delete"/>
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
    </div>
</body>
</html>