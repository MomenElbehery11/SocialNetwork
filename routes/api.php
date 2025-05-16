<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CommentController;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\EnsureUserIsActive;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserProfileController;
use App\Http\Controllers\Api\FriendRequestController;
/*
|--------------------------------------------------------------------------
| API Routes
|-------------------------------------------------------------------------- 
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Register a new user
// Method: POST
// Body: { name, email, password, password_confirmation }
Route::post('/auth/register', [UserController::class, 'createUser']);
// Login user and return access token
// Method: POST
// Body: { email, password }
Route::post('/auth/login', [UserController::class, 'loginUser']);


//for adding comments
Route::post('/posts/{postId}/comments', [CommentController::class, 'store'])
    ->middleware(['auth:sanctum', EnsureUserIsActive::class]);

    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::middleware(['auth:sanctum'])->group(function () {
        // Like a post
        Route::post('/likes', [LikeController::class, 'store']);
    
        // Unlike a post
        Route::delete('/likes/{postId}', [LikeController::class, 'destroy']);
    });

 // Auth: Required (Bearer token)
 // Full CRUD operations on posts (GET, POST, PUT, DELETE)
    //posts
    // GET /posts        -> index() method in PostController
    // POST /posts       -> store() method in PostController
    // GET /posts/{id}   -> show() method in PostController
    // PUT/PATCH /posts/{id} -> update() method in PostController
    // DELETE /posts/{id} -> destroy() method in PostController
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('posts', PostController::class);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [UserProfileController::class, 'profile']);
    // List all users
    Route::get('/users', [UserProfileController::class, 'index']);
    // Update user bio
    // Body: { bio }
    Route::put('/update-bio', [UserProfileController::class, 'updateBio']);
    // Update user bio  
    //Body: { bio }
    Route::put('/update-name', [UserProfileController::class, 'updateName']);
    // Update user name
    // Body: { name }
    Route::put('/update-email', [UserProfileController::class, 'updateEmail']);
    // Update user email: expects { email } in POST body
    // Auth required: Bearer token
    Route::put('/update-image', [UserProfileController::class, 'updateImage']);
    // Update profile picture
    Route::get('/users/search', action: [UserProfileController::class, 'search']);
});
//friends section


Route::middleware('auth:sanctum')->group(function () {
    // send friend request
    Route::post('/friend-request/send/{receiverId}', [FriendRequestController::class, 'sendRequest'])->name('friend-request.send');

    // show friends reuests
    Route::get('/friend-requests', [FriendRequestController::class, 'showRequests'])->name('friend-requests');

    // accept request
    Route::put('/friend-request/accept/{requestId}', [FriendRequestController::class, 'acceptRequest'])->name('friend-request.accept');

    // decline request
    Route::put('/friend-request/decline/{requestId}', [FriendRequestController::class, 'declineRequest'])->name('friend-request.decline');

    //show friends
    Route::get('/friends', [FriendRequestController::class, 'showFriends'])->name('friends');
});

