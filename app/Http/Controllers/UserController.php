<?php

namespace App\Http\Controllers;
use Laravel\Jetstream\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function showProfile()
    {
        $user = Auth::user();

        $name = $user->name;
        $email = $user->email;
        $bio = $user->bio;
        $image = $user->image;

        $users = User::all();

        return view('profile', compact('name', 'email', 'bio', 'image', 'users'));
    }

    public function index(Request $request)
    {
        $query = $request->input('query');

        $users = User::where('id', '!=', auth()->id())
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%");
            })
            ->get();

        $authUser = auth()->user();

        return view('users.index', compact('users', 'authUser'));
    }

    private function uploadImage(Request $request, $inputName)
    {
        if ($request->hasFile($inputName)) {
            $file = $request->file($inputName);
            $path = $file->store('profile_pictures', 'public');
            return $path;
        }
        return null;
    }

    public function storeBio(Request $request, $id)
    {
        $request->validate([
            'bio' => 'nullable|string|max:1000',
        ]);

        $user = User::findOrFail($id);
        $user->bio = $request->bio;
        $user->save();

        return redirect('profile')->with('success', 'Bio updated successfully.');
    }

    public function storeName(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->save();

        return redirect('profile')->with('success', 'Name updated successfully.');
    }

    public function storeEmail(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email|max:255|unique:users,email,' . $id,
        ]);

        $user = User::findOrFail($id);
        $user->email = $request->email;
        $user->save();

        return redirect('profile')->with('success', 'Email updated successfully.');
    }

    public function storeImage(Request $request, $id)
    {
        $request->validate([
            'PP' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $image = $this->uploadImage($request, 'PP');
        if ($image) {
            $user = User::findOrFail($id);
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

public function showFriends()
{
    $user = auth()->user();
    $friends = $user->friends; // كل الأصدقاء

    return view('users.friends', compact('friends'));
}
// app/Http/Controllers/UserController.php

public function removeFriend($friendId)
{
    $user = auth()->user();

    // نتحقق لو فيه علاقة صداقة بين اليوزر والصديق
    $user->friends()->detach($friendId); // نستخدم detach لحذف العلاقة

    return back()->with('message', 'Friend removed successfully.');
}

// إضافة فريق للمستخدم عند التسجيل
public function createUserAndAssignTeam(Request $request)
{
    $user = User::create($request->all());

    $team = Team::create([
        'user_id' => $user->id,
        'name' => 'Default Team',
        'personal_team' => true, // إذا كنت تستخدم الفرق الشخصية
    ]);

    // تعيين الفريق كـ currentTeam
    $user->currentTeam()->associate($team);
    $user->save();

    return redirect()->route('dashboard');
}

}
