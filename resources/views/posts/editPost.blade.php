<form action="{{ route('post.update', $post->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div>
        <label for="body">Body:</label>
        <textarea name="body" rows="5" cols="30">{{ $post->body }}</textarea>

        <label for="image">Image:</label><br>
        <input type="file" name="image"><br><br>
    </div>

    <button type="submit">Update</button>
</form>
