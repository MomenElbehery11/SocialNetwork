<h2>Enter The New Name :</h2>
<form action="{{ route('user.email.edit', Auth::user()->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label for="email">Email:</label><br>

    <input type="email" name="email" id="">
    <button type="submit">Save</button>
</form>
