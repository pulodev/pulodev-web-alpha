<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(User $user)
    {
        if(!$user->exists())
            abort(404);

        $user->load('links');
        
        return view('user.profile', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('user.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'username' => 'required|min:3|max:15|alpha_dash||unique:users,username,'.$user->id,
            'fullname' => 'max:30',
            'bio' => 'max:200'
        ]);
        
        $user->update([
            'username' => $request->username, 
            'fullname' => $request->fullname, 
            'bio' => $request->bio, 
            'website_url' => $request->website_url, 
        ]);

        //change session token
        $request->session()->regenerateToken();
        return redirect('/@' . $user->username)->with('success', 'profile berhasil diupdate');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
