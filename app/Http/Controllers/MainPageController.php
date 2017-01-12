<?php
namespace App\Http\Controllers;

use App\Task;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class MainPageController extends Controller
{
    public function getUserMain()
    {
        $user = Auth::user();
        $tasks = Task::where('userid','=',$user->id)->get();
        return view('mainpage', ['user' => Auth::user(), 'tasks' => $tasks]);
    }
}