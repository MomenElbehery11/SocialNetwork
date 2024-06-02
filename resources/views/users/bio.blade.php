<form action="{{ route('user.bio.add', Auth::user()->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label for="bio">Bio:</label><br>
    <textarea name="bio" id="bio" rows="5" cols="30"></textarea><br><br>

    <button type="submit">Save</button>
</form>
