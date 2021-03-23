<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class AuthGitHubController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handlProviderCallback()
    {
        $githubUser = Socialite::driver('github')->user();
        // dd($githubUser);
        
        // $user = User::where('email',  $githubUser->getEmail())->first();
        
        // $user = User::firstOrCreate(
        //     [
        //        'provider_id' => $githubUser->getId(),
        //     ],
        //     [
        //        'email' => $githubUser->getEmail(),
        //        'name'  => $githubUser->getName(),
        //     ]
        //  );
        $user = User::where('email', $githubUser->getEmail())->first();

        if( !$user ){      
           $user = User::create([         
              'email'       => $githubUser->getEmail(),
              'name'        => $githubUser->getName(),                  
           ]);
        }     
        
        //Log the user 
        auth()->login($user, true);
        //Redirect to dashboard
        return redirect('dashboard');
    }
}
