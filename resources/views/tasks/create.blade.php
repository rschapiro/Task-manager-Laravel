<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Create a Task</h1>
    <form method="POST" action="{{route('task.store')}}">
        @csrf
        <div>
            <label>Title</label>
            <input type="text" name="title" placeholder="Title" value="{{ old('title') }}"/>
            <span>
                {{ $errors->first('title') }}
            </span>
        </div>
        <div>
            <label>Description</label>
            <input type="text" name="description" placeholder="Description" value="{{ old('description') }}"/>
            <span>
                {{ $errors->first('description') }}
            </span>
        </div>
        <div>
            <input type="submit" value="Create new task"/>
        </div>
    </form>
</body>
</html>