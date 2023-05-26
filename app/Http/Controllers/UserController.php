<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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


}







    

