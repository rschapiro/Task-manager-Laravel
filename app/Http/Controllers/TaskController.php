<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\TaskRequest;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(){
        // $tasks = Task::latest()->paginate(5);
        // // return view('tasks.index', ['tasks' => $tasks]);
        // return view('tasks.index', compact('tasks'))->with(request()->input('page'));

        $tasks = Task::where('title', 'Hej')->get();

        $tasks = Task::chunk(2, function($tasks) {
            foreach($tasks as $task){
                print_r($task);
            }
        });

        return view('tasks.elo', [
            'tasks' => $tasks
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request){
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        // From YouTube with Søren Spangsberg Jørgensen
        // Task::create($request->all());
        Task::create($data);

        return redirect()->route('task.index')->with('success', 'Task created successfully');
    }

    /**
     * Display the specified resource.
     * 
     * @param \App\Models\Task $task
     * @return \Illuminate\Http\Response
     */
    public function show($taskId)
    {
        $task = Task::where('id', $taskId)->first();
        return view('tasks.show', ['task' => $task]);
    }

    /**
     * Show the form for editing the specified resource.
     * 
     * @param \App\Models\Task $task
     * @return \Illuminate\Http\Response
     */
    public function edit($taskId){
        // dd($taskId);
        $task = Task::where('id', $taskId)->first();
        return view('tasks.edit', ['task' => $task]);
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Task $task
     * @return \Illuminate\Http\Response
     */
    public function update(TaskRequest $request, $id)
    {
        // dd($request->all() , $id);
        $task = Task::findOrFail($id);

        $data = $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        $task->update($data);

        // Validate the input data
        // $validatedData = $request->validate([
        //     'title' => 'required|max:255',
        //     'description' => 'required',
        // ]);
        // Update the task with the validated data
        // $task->update($validatedData);



        return redirect()->route('task.index')->with('success', 'Task updated successfully');
    }

    public function updateModal(TaskRequest $request)
    {
        $task = Task::findOrFail($request->id);

        $data = $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        $task->update($data);

        // Validate the input data
        // $validatedData = $request->validate([
        //     'title' => 'required|max:255',
        //     'description' => 'required',
        // ]);
        // Update the task with the validated data
        // $task->update($validatedData);



        return redirect()->route('task.index')->with('success', 'Task updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param \App\Models\Task $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('task.index')->with('success', 'Task deleted successfully');
    }

    public function setStatus(Request $request, $id)
    {
        // dd($request->all());

        Task::where('id', $id)->update(['completed' => $request->is_completed ? 0 : 1]);
        // Task::where('id', $id)->update(['completed_by' => $request->completed_by]);
        
        $message = $request->is_completed ? 'Task set to incomplete' : 'Task completed successfully';
        
        return redirect()->back()->with('success', $message);
        
        // TESTING:
        // dd(Task::where('id', $id)->first()->toSql());

        // Alternative way of writing line 121:
        // $task = Task::findOrFail($id);
        // $task->completed = 1;
        // $task->save();

    }

    public function search()
    {
        $searchText = $_GET['query'];
        $tasks = Task::where('title', 'LIKE', '%'.$searchText.'%')->get();

        return view('tasks.search', compact('tasks'));
    }
}
