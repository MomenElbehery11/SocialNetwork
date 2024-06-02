<h2>Enter The New Name :</h2>
<form action="{{ route('user.name.edit', Auth::user()->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label for="name">Name:</label><br>
    <input type="name" name="name" id="">

    <button type="submit">Save</button>
</form>
