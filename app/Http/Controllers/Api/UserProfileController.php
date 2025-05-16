<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Traits\ApiResponser;

class UserProfileController extends Controller
{
    use ApiResponser;

    public function profile()
    {
        $user = Auth::user();
        return $this->success($user, 'Profile fetched successfully', 200);
    }

    public function index()
    {
        $users = User::all();
        return $this->success($users, 'Users fetched successfully', 200);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->error('Validation Error', $validator->errors(), 422);
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return $this->success($user, 'User registered successfully', 201);
    }

    public function updateBio(Request $request)
    {
        $request->validate(['bio' => 'nullable|string']);

        $user = Auth::user();
        $user->bio = $request->bio;
        $user->save();

        return $this->success($user, 'Bio updated successfully', 200);
    }

    public function updateName(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);

        $user = Auth::user();
        $user->name = $request->name;
        $user->save();

        return $this->success($user, 'Name updated successfully', 200);
    }

    public function updateEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|unique:users,email,' . Auth::id()]);

        $user = Auth::user();
        $user->email = $request->email;
        $user->save();

        return $this->success($user, 'Email updated successfully', 200);
    }

    public function updateImage(Request $request)
    {
        $request->validate([
            'image' => 'required|string',
        ]);

        $user = Auth::user();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('profile_pictures', 'public');
            $user->image = $path;
            $user->save();
        }

        return $this->success($user, 'Profile picture updated successfully', 200);
    }

    public function search(Request $request)
    {
        $query = $request->query('query');

        $users = User::where('name', 'like', "%$query%")
                     ->orWhere('email', 'like', "%$query%")
                     ->get();

        return $this->success($users, 'Search results', 200);
    }
}
