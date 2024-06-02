<form action="{{ route('user.image.edit', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div>
        <label for="PP">Upload Profile Picture:</label>
        <input type="file" id="PP" name="PP" required>
    </div>
    <button type="submit">Upload</button>
</form>
