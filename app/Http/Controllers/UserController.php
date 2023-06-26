<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('status', false)->get();
        return view('general.users', ['data' => $users]);
    }

    public function listApi()
    {
        $users = User::where('status', false)->get();
        return response()->json([
            'data' => $users,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = User::where('id', Auth::id())->first();

        if ($user->role == 'project') {
            return view('project.settings', ['data' => $user]);
        } elseif ($user->role == 'finance') {
            return view('finance.settings', ['data' => $user]);
        } elseif ($user->role == 'general') {
            return view('general.settings', ['data' => $user]);
        } else {
            return redirect('/login');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "email" => "required|email|unique:users",
            "names" => "required",
            "role" => "required|in:project,finance",
            "password" => "required",
            "confirmPassword" => "required"
        ]);

        if ($request->password == $request->confirmPassword) {
            $user = new User;
            $user->email = $request->email;
            $user->name = $request->names;
            $user->role = $request->role;
            $user->password = bcrypt($request->password);
            $user->save();
            return redirect('/');
        } else {
            return redirect('/register')->withErrors(['msg' => 'Passwords not match']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $user = User::where('id', Auth::guard('api')->id())->first();
        if ($user != null) {
            return response()->json(['user' => $user], 200);
        } else {
            return response()->json(['error' => 'Not allowed'], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|email",
            "password" => "required",
            "confirmPassword" => "required"
        ]);

        if ($request->password == $request->confirmPassword) {
            $user = User::where('id', Auth::id())->first();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->update();
            if (Auth::user()->role == 'general') {
                return redirect('/general/settings');
            } elseif (Auth::user()->role == 'finance') {
                return redirect('/finance/settings');
            } else {
                return redirect('/project/settings');
            }
        } else {
            if (Auth::user()->role == 'general') {
                return redirect('/general/settings')->withErrors(['msg' => 'Passwords not match']);
            } elseif (Auth::user()->role == 'finance') {
                return redirect('/finance/settings')->withErrors(['msg' => 'Passwords not match']);
            } else {
                return redirect('/project/settings')->withErrors(['msg' => 'Passwords not match']);
            }
        }
    }

    public function updateApi(Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|email",
            "password" => "required"
        ]);

        $user = User::where('id', Auth::guard('api')->id())->first();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->update();
        return response()->json([
            'message' => 'User details updated'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('/general/users');
    }

    public function approvedUser($id)
    {
        $user = User::find($id);
        $user->status = true;
        $user->update();
        return redirect('/general/users');
    }

    public function rejectApi($id)
    {
        $user = User::find($id)->first();
        $user->delete;
        return response()->json([
            'message' => 'User rejected'
        ], 200);
    }

    public function approveApi($id)
    {
        $user = User::find($id)->first();
        $user->status = true;
        $user->update();
        return response()->json([
            'message' => 'User approved'
        ], 200);
    }
}
