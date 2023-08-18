@extends('tasks.layout')

@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Add New Task</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('task.index') }}">Back</a>
        </div>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('task.store') }}">
    @csrf

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Title:</strong>
                <input type="text" name="title" class="form-control" placeholder="Title" value="{{ old('title') }}">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Description:</strong>
                {{-- <input type="text" name="description" class="form-control" placeholder="Description" value="{{ old('description') }}"> --}}
                <textarea type="text" name="description" class="form-control" placeholder="Description" style="height:150px"></textarea>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Create Task</button>
        </div>
    </div>
</form>


@endsection




{{-- <!DOCTYPE html>
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
</html> --}}