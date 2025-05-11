<?php

namespace App\Http\Controllers;

use App\Models\UserStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserStatusController extends Controller
{
    public function getUserStatus()
    {
        $userStatus = UserStatus::with('user')->where('user_id', auth()->id())->first();
        return response()->json(['user_status' => $userStatus], 200);
    }

    public function updateUserStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:active,inactive,suspended,banned',
            'status_message' => 'nullable|string|max:255',
            'profile_visibility' => 'required|in:public,private,friends_only'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $userStatus = UserStatus::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'status' => $request->status,
                'status_message' => $request->status_message,
                'profile_visibility' => $request->profile_visibility,
                'last_active' => now(),
                'is_online' => true
            ]
        );

        return response()->json(['message' => 'User status updated successfully', 'user_status' => $userStatus], 200);
    }

    public function updateOnlineStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'is_online' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $userStatus = UserStatus::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'is_online' => $request->is_online,
                'last_active' => now()
            ]
        );

        return response()->json(['message' => 'Online status updated successfully', 'user_status' => $userStatus], 200);
    }

    public function updateProfileVisibility(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profile_visibility' => 'required|in:public,private,friends_only'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $userStatus = UserStatus::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'profile_visibility' => $request->profile_visibility,
                'last_active' => now()
            ]
        );

        return response()->json(['message' => 'Profile visibility updated successfully', 'user_status' => $userStatus], 200);
    }
} 