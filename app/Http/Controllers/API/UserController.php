<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Store the new user
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $validatedData = $request->validated();

            // Hash password
            $validatedData['password'] = Hash::make($validatedData['password']);

            // Hapus password_confirmation dari data yang akan disimpan
            unset($validatedData['password_confirmation']);

            User::create($validatedData);

            return response()->json([
                'message' => 'Account created successfully'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Registration failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Log in user
     */
    public function auth(AuthUserRequest $request)
    {
        try {
            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'message' => 'Invalid credentials'
                ], 401); // Return status 401 untuk invalid credentials
            }

            return response()->json([
                'user' => UserResource::make($user),
                'access_token' => $user->createToken('auth_token')->plainTextToken
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }

    /**
     * Update user infos
     */
    public function UpdateUserProfile(Request $request)
    {
        $request->validate([
            'profile_image' => 'image|mimes:png,jpg,jpeg|max:2048'
        ]);

        if ($request->has('profile_image')) {
            //check if the old image exists and remove it
            if (File::exists(asset($request->user()->profile_image))) {
                File::delete(asset($request->user()->profile_image));
            }
            //get and store the new image file
            $file = $request->file('profile_image');
            $profile_image_name = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('images/users/', $profile_image_name, 'public');
            //update the user image
            $request->user()->update([
                'profile_image' =>  'storage/images/users/' . $profile_image_name
            ]);
            //return the response
            return response()->json([
                'message' => 'Profile image updated successfully',
                'user' => UserResource::make($request->user())
            ]);
        } else {
            //update the user info
            $request->user()->update([
                'country' => $request->country,
                'city' => $request->city,
                'address' => $request->address,
                'zip_code' => $request->zip_code,
                'phone_number' => $request->phone_number,
                'profile_completed' => 1,
            ]);
            //return the response
            return response()->json([
                'message' => 'Profile updated successfully',
                'user' => UserResource::make($request->user())
            ]);
        }
    }
}
