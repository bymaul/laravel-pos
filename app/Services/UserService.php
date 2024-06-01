<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function getAllNonAdminUsers()
    {
        return User::isNotAdmin()->get();
    }

    public function createUser(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        return User::create($data);
    }

    public function updateUser(User $user, array $data)
    {
        $user->update($data);
    }

    public function deleteUser($id)
    {
        User::findOrFail($id)->delete();
    }
}
