<?php
namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function postSignUp(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users',
            'first_name' => 'required|max:120',
            'last_name' => 'required|max:120',
            'admin' => 'required',
            'password' => 'required|min:4'
        ]);

        $email = $request['email'];
        $first_name = $request['first_name'];
        $last_name = $request['last_name'];
        $admin = $request['admin'];
        $password = bcrypt($request['password']);

        $user = new User();
        $user->email = $email;
        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->admin = $admin;
        $user->password = $password;

        $user->save();


        return redirect()->route('users');
    }

    public function postSignIn(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
            return redirect()->route('mainpage');
        }
        return redirect()->route('home');
    }

    public function getLogout()
    {
        Auth::logout();
        return redirect()->route('home');
    }

    public function getAccount()
    {
        return view('account', ['user' => Auth::user()]);
    }

    public function postSaveAccount(Request $request)
    {
        $this->validate($request, [
           'first_name' => 'required|max:120'
        ]);

        $user = Auth::user();
        $old_name = $user->first_name;
        $user->first_name = $request['first_name'];
        $user->update();
        $file = $request->file('image');
        $filename = $request['first_name'] . '-' . $user->id . '.jpg';
        $old_filename = $old_name . '-' . $user->id . '.jpg';
        $update = false;
        if (Storage::disk('local')->has($old_filename)) {
            $old_file = Storage::disk('local')->get($old_filename);
            Storage::disk('local')->put($filename, $old_file);
            $update = true;
        }
        if ($file) {
            Storage::disk('local')->put($filename, File::get($file));
        }
        if ($update && $old_filename !== $filename) {
            Storage::delete($old_filename);
        }
        return redirect()->route('account');
    }

    public function getUserImage($filename)
    {
        $file = Storage::disk('local')->get($filename);
        return new Response($file, 200);
    }

    public function getUserList()
    {
        if (Auth::user() -> isAdmin()) {
            $users = User::orderBy('created_at', 'desc')->paginate(5);
            return view('users', ['users' => $users]);
        } else {
            return redirect()->route('home');
        }
    }

    public function getDeleteUser($user_id)
    {
        $user = User::where('id', $user_id)->first();
        if (Auth::user() -> isAdmin()) {
            $user->delete();
            return redirect()->route('users')->with(['message' => 'Sikeresen törölve!']);
        }
        return redirect()->back();
    }

    public function postEditUser(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'last_name' => 'required',
            'first_name' => 'required',
            'admin' => 'required'
        ]);
        $user = User::find($request['userId']);
        if (Auth::user() -> isAdmin()) {
            $user->email = $request['email'];
            $user->last_name = $request['last_name'];
            $user->first_name = $request['first_name'];
            $user->admin = $request['admin'];
            $user->update();
            return response()->json(['new_email' => $user->email,
                'new_first_name' => $user->first_name,
                'new_last_name' => $user->last_name,
                'new_admin' => $user->admin
            ], 200);
        }

        return redirect()->back();
    }
}