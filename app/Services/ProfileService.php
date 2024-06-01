<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class ProfileService
{
    public function getUserProfile($user)
    {
        return $user;
    }

    public function updateProfile($user, $data)
    {
        $user->fill($data);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return $user;
    }

    public function updateAvatar($user, $avatar)
    {
        $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
        $avatar->move(public_path('assets/img'), $avatarName);

        if (File::exists(public_path($user->avatar))) {
            File::delete(public_path($user->avatar));
        }

        $user->update(['avatar' => 'assets/img/' . $avatarName]);

        return $avatarName;
    }
}
