@extends('tasks.layout')

@section('content')
    <div class="m-auto w-4/5 py-24">
        <div class="text-center">
            <h1 class="text-5xl uppercase bold">
                Tasks with Eloquent
            </h1>
        </div>

        @foreach ($tasks as $task)
            <div class="w-5/6 py-10">
                <div class="m-auto">
                    <span class="uppercase text-blu-500">
                        Completed: {{ $task->completed }}
                    </span>

                    <h2 class="text-gray-700">
                        {{ $task->title }}
                    </h2>

                    <p class="text-lg">
                        {{ $task->description }}
                    </p>

                    <hr class="mt-4 mb-8">
                </div>
            </div>
        @endforeach

    </div>
@endsection
