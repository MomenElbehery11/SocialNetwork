<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
class UserController extends Controller
{

    public function showProfile()
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Retrieve user's name and email
        $name = $user->name;
        $email = $user->email;
        $bio = $user->bio;
        $image = $user->image;

        $users = User::all();

        // Return the data to a view or process as needed
        return view('profile', compact('name', 'email','bio','image','users'));
    }
    public function index()
    {
        // Retrieve all users from the database
        $users = User::all();

        // Pass the users to the 'users.index' view
        return view('users.index', compact('users'));
    }
    ///////////////////////////////////////
    private function uploadImage(Request $request, $inputName)
    {
        if ($request->hasFile($inputName)) {
            $file = $request->file($inputName);
            $path = $file->store('profile_pictures', 'public');
            return $path;
        }
        return null;
    }

    ////////////////////////////
    public function storeBio(Request $request,$id){
        $user=User::findorFail($id);
        $user->bio=$request->bio;
        $user->save();
        return redirect('profile');
        }

    public function storeName(Request $request,$id){
        $user=User::findorFail($id);
        $user->name=$request->name;
        $user->save();
        return redirect('profile');
    }

    public function storeEmail(Request $request,$id){
        $user=User::findorFail($id);
        $user->email=$request->email;
        $user->save();
        return redirect('profile');

    }
        public function storeImage(Request $request,$id){

            $request->validate([
                'PP' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate the image
            ]);

        $image = $this->uploadImage($request, 'PP');
            if ($image) {
                $user = User::findorFail($id);
                $user->image = $image;
                $user->save();
                return redirect('profile')->with('success', 'Profile picture updated successfully.');
            }
            return redirect('profile')->with('error', 'Image upload failed.');
        }
        public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

    User::create([
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'password' => bcrypt($request->input('password')),
    ]);

    return redirect()->route('users.index')->with('success', 'User created successfully.');
}

public function search(Request $request)
    {
        $query = $request->input('query');

        $users = User::where('name', 'like', "%$query%")
                     ->orWhere('email', 'like', "%$query%")
                     ->get();

        return view('users.search_results', compact('users'));
    }
}


