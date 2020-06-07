<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskResource;
use App\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $now = Carbon::now();

        $tasks = Task::where('best_before', '<', $now)->get();
        foreach ($tasks as $task) {
            $this->destroy($task->id);
        }

        return TaskResource::collection(auth()->user()->tasks()->get());

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'description' => 'required|string',
            'completed' => 'required|boolean',
            'best_before' => 'required|date'
        ]);

        $task = Task::create([
            'user_id' => auth()->user()->id,
            'description' => $request->description,
            'completed' => $request->completed,
            'best_before' => $request->best_before
        ]);

        return response($task, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new TaskResource(Task::findOrFail($id));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $task = new TaskResource(Task::findOrFail($id));
        $data = $request->validate([
            'description' => 'required|string',
            'completed' => 'required|boolean',
            'best_before' => 'required|date'
        ]);

        $task->update($data);
        return response($task, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $task = new TaskResource(Task::findOrFail($id));

        $task->delete();

        return response()->json('Task deleted', 200);
    }
}
