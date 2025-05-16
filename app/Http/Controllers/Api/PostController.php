<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;

class PostController extends Controller
{
    use ApiResponser;

    public function index()
    {
        $posts = Post::with('user')->latest()->get();
        return $this->success(PostResource::collection($posts), 'Posts fetched successfully', 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'body'  => 'required|string',
            'image' => 'nullable|string', // base64 image
        ]);

        if ($validator->fails()) {
            return $this->error('Validation Error', $validator->errors(), 422);
        }

        $data = $validator->validated();
        $data['user_id'] = auth()->id();

        // Save image if base64 provided
        if (!empty($data['image'])) {
            $imagePath = $this->saveBase64Image($data['image']);
            $data['image'] = $imagePath;
        }

        $post = Post::create($data);

        return $this->success(new PostResource($post), 'Post created successfully.', 201);
    }

    public function show($id)
    {
        $post = Post::with('user')->findOrFail($id);
        return $this->success(new PostResource($post), 'Post fetched successfully', 200);
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'body'  => 'sometimes|required|string',
            'image' => 'nullable|string', // base64 image
        ]);

        if ($validator->fails()) {
            return $this->error('Validation Error', $validator->errors(), 422);
        }

        $data = $validator->validated();

        if (!empty($data['image'])) {
            $imagePath = $this->saveBase64Image($data['image']);
            $data['image'] = $imagePath;
        }

        $post->update($data);

        return $this->success(new PostResource($post), 'Post updated successfully.', 200);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return $this->success(null, 'Post deleted successfully.', 200);
    }

    /**
     * Save base64 image to storage.
     *
     * @param string $base64Image
     * @return string|null
     */
    private function saveBase64Image($base64Image)
    {
        if (!preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
            return null;
        }

        $image = substr($base64Image, strpos($base64Image, ',') + 1);
        $image = base64_decode($image);
        $extension = strtolower($type[1]);
        $fileName = uniqid() . '.' . $extension;

        Storage::disk('public')->put("uploads/$fileName", $image);

        return "uploads/$fileName";
    }
}
