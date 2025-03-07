<?php

namespace App\Http\Controllers;

use Auth;
use Image;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function show(User $user)
    {
        if(!$user->exists())
            abort(404);

        $user->load('links', 'resources');
        
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

    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|file|image|max:1024',
        ]);
        
        $user = Auth::user();
        $prevAvatar = $user->avatar_url;
        
        $imgName = time() . '-' . $user->username . '.' . $request->image->getClientOriginalExtension();
        
        //resize image using imageintervention
        $imgIntervention = Image::make(file_get_contents($request->image))
                            ->resize(350, 350, function($constraint) {
                                $constraint->aspectRatio();
                                $constraint->upsize();
                            })->stream();

        Storage::put('avatar/'. $imgName, $imgIntervention, 'public');
        $user->update(['avatar_url' => $imgName ]);

        //remove old avatar
        if($prevAvatar != "") 
          Storage::delete('avatar/'. $prevAvatar);
        
        return ['msg' => 'success', 'avatar' => $user->avatar_url];
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
