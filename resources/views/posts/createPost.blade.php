<form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label for="body">enter new post</label><br>
    <textarea name="body" rows="5" cols="30"></textarea><br><br>

    <label for="image">Image:</label><br>
    <input type="file" name="image"><br><br>

    <button type="submit">Save</button>
</form>
