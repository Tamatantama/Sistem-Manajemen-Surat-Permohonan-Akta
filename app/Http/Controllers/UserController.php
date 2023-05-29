<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }


    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $user->bio = $request->input('bio');
        $user->save();
        
        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
    }


    public function showProfile(User $user)
    {
        return view('user.profile', compact('user'));
    }



    public function myProfile()
    {
        $user = Auth::user();
        return view('user.my-profile', compact('user'));
    }

   

    public function registerSuccess(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,operator,verificator', // Assuming 'role' can be either 'admin' or 'user'
        ]);

        // Create a new user instance
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;

        // Save the user to the database
        $user->save();

        // Redirect to the login page with success message
        return redirect()->route('login')->with('success', 'Registration successful. Please login with your new account.');
    }


}







    

