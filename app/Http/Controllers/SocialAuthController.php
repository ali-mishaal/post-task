<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirectToFacebook(): RedirectResponse
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback(): RedirectResponse
    {
        $user = Socialite::driver('facebook')->user();

        $existingUser = $this->userRepository->getUserByEmail($user->getEmail());

        if ($existingUser) {
            Auth::login($existingUser);
        } else {
            $newUser = $this->userRepository->createUser([
                'name' => $user->getName(),
                'email' => $user->getEmail(),
            ]);

            Auth::login($newUser);
        }

        return redirect('/timeline');
    }
}
