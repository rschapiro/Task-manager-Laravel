@extends('tasks.layout')

@section('content')

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">My Task Manager</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <!-- Other navigation links here -->
                    <form id="taskForm" class="form-inline my-2 my-lg-0" method="GET"
                        action="{{ route('task.search') }}">
                        <input class="form-control mr-sm-2" type="search" placeholder="Search Tasks on this page"
                            id="myInput">
                        {{-- <button class="btn btn-outline-light my-2 my-sm-0">Search</button> --}}
                    </form>
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
                {{-- Old button --}}
                {{-- <a class="btn btn-success" href="{{ route('task.create') }}" id="createNewTask">Add New Task</a> --}}

                <!-- Trigger the modal with a button -->
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">Add New
                    Task</button>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered" id="myTable">
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
                            {{-- <a class="btn btn-primary" data-toggle="modal" data-target="#myEditModal">Modal Edit</a> --}}
                            <a href="javascript:;" class="btn btn-primary" onclick="editTask({{$task}})" data-toggle="modal" 
                            data-target="#myEditModal">Modal Edit</a>
                            <a class="btn btn-success" href="{{ route('task.edit', $task->id) }}">Edit</a>
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
                            <button type="submit" class="btn btn-{{ $task->completed ? 'success' : 'warning' }}">Set
                                status</button>
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

    <!-- Create Modal Start -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('task.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Title:</strong>
                                    <input type="text" name="title" class="form-control" placeholder="Title"
                                        value="{{ old('title') }}">
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    <!-- Create Modal End -->

    <!-- Edit Modal Start -->
    <div id="myEditModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('task.updateModal') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Title:</strong>
                                    <input type="text" name="title" class="form-control" placeholder="Title"
                                        value="{{ old('title') }}">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Description:</strong>
                                    {{-- <input type="text" name="description" class="form-control" placeholder="Description" value="{{ old('description') }}"> --}}
                                    <textarea type="text" name="description" class="form-control" placeholder="Description" style="height:150px" id="task_description"></textarea>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">Update Task</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    <!-- Edit Modal End -->

    <!-- Script Start -->
    <script>
        $(document).ready(function() {
            $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });

        let task;

        function editTask(task) {
            // $('#myEditModal').modal('toggle');
            // $('#task_modal_heading').text('Edit Task / Service');
            // $('#task_modal_btn').text('Update');
            console.log(task);
            $("input[name=id]").val(task.id);
            $("input[name=title]").val(task.title);
            // $("input[name=price]").val(product.price);
            $("textarea#task_description").val(task.description);
        }
    </script>
    <!-- Script End -->



@endsection
