<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response as HttpResponse;
use Laravel\Passport\HasApiTokens;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $email = $request->input('email');
        $password = $request->input('password');
        $user = User::where('email', $email)->first();
        if ($user != null) {
            $passwordMatch = Hash::check($password, $user->password);
            if ($passwordMatch) {
                if ($user->status == false) {
                    return redirect('/')->withErrors(['msg' => 'Your account is pending']);
                } else {
                    Auth::login($user);
                    if ($user->role == 'general') {
                        return redirect("/general");
                    } elseif ($user->role == 'finance') {
                        return redirect("/finance");
                    } elseif ($user->role == 'project') {
                        return redirect("/project");
                    }
                }
            } else {
                return redirect("/")->withErrors(['msg' => 'Incorect password']);
            }
        } else {
            return redirect('/')->withErrors(['msg' => 'Incorect email and password']);
        }
    }



    public function logout()
    {
        if (Auth::check()) {
            Auth::logout();
            return redirect(route("login"));
        }
    }

    public function mobileLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email', $email)->first();

        if ($user != null) {
            $passwordMatch = Hash::check($password, $user->password);

            if ($passwordMatch) {
                if ($user->status == false) {
                    return response()->json(['error' => 'Your account is pending'], 401);
                } else {
                    Auth::login($user);
                    $token = $user->createToken('token')->accessToken;
                    return response()->json([
                        'user' => $user,
                        'token' => $token
                    ], 200);
                }
            } else {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }
        } else {
            return response()->json(['error' => 'Invalid email'], 401);
        }
    }

    public function mobileRegister(Request $request)
    {
        $request->validate([
            "email" => "required|email|unique:users",
            "names" => "required",
            "role" => "required|in:project,finance",
            "password" => "required",
        ]);


        $user = new User;
        $user->email = $request->email;
        $user->name = $request->names;
        $user->role = $request->role;
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json([
            'message' => 'account created',
        ], 200);
    }
}
