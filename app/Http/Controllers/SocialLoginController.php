<?php

namespace App\Http\Controllers;

use Auth;
use Image;
use Carbon\Carbon;
use App\Models\User;
use App\Models\UserSocial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        $userSocial = Socialite::driver($provider)->user();
        $user = User::where('email', $userSocial->getEmail())->first();

        //if user not exists yet
        if ($user == null)
            return $this->registerUser($userSocial, $provider);

        UserSocial::firstOrcreate([
            'user_id' => $user->id,
            'social_id' => $userSocial->getId(),
            'provider' => $provider
        ]);

        Auth::login($user, true);
        return redirect('/');
    }

    private function registerUser($userSocial, $provider)
    {
        $user = '';

        DB::transaction(function () use ($userSocial, $provider, &$user) {
            $fullName = $userSocial->getName();
            $username = $this->makeUsername($userSocial, $provider);
            $avatar_url = $this->makeAvatar($userSocial->getAvatar(), $username);

            $user = User::create([
                        'username' => $username,
                        'fullname' => $fullName,
                        'email'  => $userSocial->getEmail(),
                        'avatar_url' => $avatar_url,
                        'email_verified_at' => Carbon::now()
                    ]);

            UserSocial::create([
                'user_id' => $user->id,
                'social_id' => $userSocial->getId(),
                'provider' => $provider
            ]);
        });

        Auth::login($user, true);
        return redirect('/')->with('success', 'Selamat datang! akun kamu sudah aktif');
    }

    private function makeUsername($userSocial, $provider) 
    {
        $username = $userSocial->getNickname();
        
        //create username from fullname
        if($username == null)
            $username = strtolower(str_replace(" ", "", $fullName)) . "_" . $provider;

            //if username already exists
        if(User::where('username', $username)->count() != 0)
            $username = $username . "_" . $provider;

        return $username;
    }

    private function makeAvatar($avatar, $username)
    {
        if($avatar == '')
            return '';

        //get image
        $imgIntervention = Image::make($avatar)->stream('jpg');         

        $imgName = time() .'-'. $username . '.jpg';
        Storage::put('avatar/'. $imgName, $imgIntervention, 'public');

        return $imgName;
    }
}
