<?php
namespace App\Http\Controllers;

use App\Task;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    public function getTaskList()
    {
        $tasks = Task::leftjoin('users', 'tasks.userid', '=', 'users.id')
            ->select('tasks.*','users.first_name')
            ->orderBy('tasks.created_at', 'desc')
            ->paginate(5);

        $users = User::orderBy('first_name');
        return view('tasks', ['tasks' => $tasks, 'users' => $users]);
    }

    public function postAddTask(Request $request)
    {
        $this->validate($request, [
            'task_name' => 'required|max:200',
            'description' => 'required',
            'userid' => 'required',
            'enddate' => 'required'
        ]);
        $task_name = $request['task_name'];
        $description = $request['description'];
        $userid = $request['userid'];
        $enddate = $request['enddate'];

        $task = new Task();
        $task->userid = $userid;
        $task->task_name = $task_name;
        $task->description = $description;
        $task->enddate = $enddate;

        $task->save();

        return redirect()->route('tasks');
    }

    public function getDeleteTask($id)
    {
        $task = Task::where('id', $id)->first();
        if (Auth::user() -> isAdmin()) {
            $task->delete();
            return redirect()->route('tasks')->with(['message' => 'Sikeresen törölve!']);
        }
        return redirect()->back();
    }




}