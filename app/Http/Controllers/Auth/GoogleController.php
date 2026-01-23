<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class GoogleController extends Controller
{
    private function socialite()
    {
        return app('Laravel\\Socialite\\Contracts\\Factory');
    }

    public function redirect()
    {
        return $this->socialite()->driver('google')->redirect();
    }

    public function callback(Request $request)
    {
        try {
            $googleUser = $this->socialite()->driver('google')->user();
        } catch (Exception $e) {
            return redirect()
                ->route('login')
                ->with('toast', ['type' => 'error', 'message' => 'Google login gagal. Silakan coba lagi.']);
        }

        $email = $googleUser->getEmail();
        if (!$email) {
            return redirect()
                ->route('login')
                ->with('toast', ['type' => 'error', 'message' => 'Google login gagal: email tidak ditemukan.']);
        }

        $user = User::query()->where('email', $email)->first();

        if (!$user) {
            $name = $googleUser->getName() ?: ($googleUser->getNickname() ?: 'User');

            $user = User::query()->create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make(Str::random(48)),
                'avatar' => $googleUser->getAvatar(),
            ]);

            $user->forceFill(['email_verified_at' => now()])->save();

            $role = Role::where('name', 'user')->first();
            if ($role && method_exists($user, 'assignRole')) {
                $user->assignRole($role);
            }
        } elseif (!$user->email_verified_at) {
            $user->forceFill(['email_verified_at' => now()])->save();
        }

        Auth::login($user, true);

        return redirect()
            ->intended(route('home'))
            ->with('toast', ['type' => 'success', 'message' => 'Berhasil login dengan Google.']);
    }
}
