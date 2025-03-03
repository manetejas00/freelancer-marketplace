<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;


class ProfileController extends Controller
{
    public function updateProfile(Request $request)
    {
        $request->validate([
            'skills' => 'required',
            'experience' => 'required',
            'hourly_rate' => 'numeric'
        ]);

        $profile = Profile::updateOrCreate(
            ['user_id' => auth()->id()],
            $request->only(['skills', 'experience', 'hourly_rate', 'portfolio'])
        );

        return response()->json(['message' => 'Profile updated successfully', 'profile' => $profile]);
    }
}
