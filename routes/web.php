<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FriendRequestController;
use App\Http\Controllers\Auth\LogoutController;
Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
//logout
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');

    Route::get('/profile', function () {
        return view('users.profile');
    })->name('profile');
});
//end of logout
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/profile', function () {
        return view('users.profile');
    })->name('profile');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/profile/bio', function () {
        return view('users.bio');
    })->name('bio');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::put('/profile/bio/{id}', [UserController::class,'storeBio'])
    ->name('user.bio.add');
});

Route::post('/users', [UserController::class, 'store'])->name('users.store');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::put('/profile/NameEdit/{id}', [UserController::class,'storeName'])
    ->name('user.name.edit');
});
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/profile/name', function () {
        return view('users.name');
    })->name('name');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::put('/profile/EmailEdit/{id}', [UserController::class,'storeEmail'])
    ->name('user.email.edit');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/profile/email', function () {
        return view('users.email');
    })->name('email');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::put('/profile/ImageEdit/{id}', [UserController::class,'storeImage'])
    ->name('user.image.edit');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/profile/image', function () {
        return view('users.image');
    })->name('image');
});

Route::get('profile/showAllUsers', [UserController::class, 'index'])
->name('index');

// Posts section

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/post/create',function(){
        return view('posts.createPost');
    })
    ->name('post.create');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::put('/post/store', [PostController::class,'postStore'])
    ->name('post.store');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/post/index', [PostController::class,'PostIndex'])
    ->name('postIndex');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::put('/post/update/{id}', [UserController::class,'update'])
    ->name('post.update');
});


Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('post.destroy');

Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('post.edit');
Route::put('/posts/{post}', [PostController::class, 'update'])->name('post.update');

// Likes
Route::post('/posts/{post}/like', [PostController::class, 'like'])->name('post.like');
Route::delete('/posts/{post}/unlike', [PostController::class, 'unlike'])->name('post.unlike');


use App\Http\Controllers\CommentController;

Route::post('/comments/{post}', [CommentController::class, 'store'])->name('comments.store');

Route::get('/post/{post}/liked-users', [PostController::class, 'likedUsers'])->name('post.liked-users');

Route::get('/users/search', [UserController::class, 'search'])->name('users.search');


//Friends

Route::middleware(['auth'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');

    // Friend requests actions
    Route::post('/friend-request/send/{id}', [FriendRequestController::class, 'sendRequest'])->name('friend-request.send');
    Route::put('/friend-request/accept/{id}', [FriendRequestController::class, 'acceptRequest'])->name('friend-request.accept');
    Route::post('/friend-request/decline/{id}', [FriendRequestController::class, 'declineRequest'])->name('friend-request.decline');

    // Display friend requests and friends
    Route::get('/friend-requests', [FriendRequestController::class, 'showRequests'])->name('friendRequests');
    Route::get('/friends', [FriendRequestController::class, 'showFriends'])->name('friends');

    // Remove friend
    Route::delete('/friends/{friendId}', [UserController::class, 'removeFriend'])->name('users.removeFriend');
});
