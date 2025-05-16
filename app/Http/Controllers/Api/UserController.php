<?php

namespace App\Http\Controllers\Api;
use App\Traits\ApiResponser;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
class UserController extends Controller
{
    use ApiResponser;
    /**
     * Create User
     * @param Request $request
     * @return User
     */
    public function createUser(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function loginUser(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $user->createToken("API TOKEN")->plainTextToken
        ]);
    }

    return response()->json([
        'message' => 'Invalid credentials'
    ], 401);
}
public function index()
{
    $users = User::all();  // أو تقدر تضيف فلترة إذا كنت عايز
    return response()->json($users);
}

public function removeFriend($friendId)
{
    $user = auth()->user();
    $friend = User::findOrFail($friendId);

    // تحقق من وجود العلاقة
    if ($user->friends()->where('friend_id', $friendId)->exists()) {
        $user->friends()->detach($friendId);
        return response()->json(['message' => 'Friend removed.']);
    }

    return response()->json(['message' => 'No such friend.'], 400);
}

}
