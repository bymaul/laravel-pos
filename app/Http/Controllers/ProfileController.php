<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Services\ProfileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    public function __construct(private readonly ProfileService $profileService) {}

    public function edit(Request $request)
    {
        $user = $this->profileService->getUserProfile($request->user());

        return view('profile.index', ['user' => $user]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $this->profileService->updateProfile($request->user(), $request->validated());

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function store(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $avatarName = $this->profileService->updateAvatar($request->user(), $request->file('avatar'));

        return back()->with('success', 'Foto profil berhasil diperbarui!')->with('avatar', $avatarName);
    }
}
