<form action="{{ route('user.bio.add', Auth::user()->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label for="bio">Bio:</label><br>
    <textarea name="bio" id="bio" rows="5" cols="30"></textarea><br><br>

    <button type="submit">Save</button>
</form>
<style>
    form {
    background-color: #f8f9fa; /* Light gray background */
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    width: 80%; /* Adjust width as needed */
    max-width: 500px; /* Maximum width */
    margin: 20px auto; /* Center the form */
}

label {
    display: block; /* Make label take full width */
    margin-bottom: 8px;
    font-weight: bold;
    color: #495057; /* Dark gray text */
}

textarea {
    width: calc(100% - 12px); /* Adjust for padding */
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ced4da; /* Light gray border */
    border-radius: 4px;
    box-sizing: border-box; /* Include padding and border in element's total width and height */
    font-family: sans-serif; /* Consistent font */
    font-size: 16px;
}

textarea:focus {
    outline: none;
    border-color: #007bff; /* Blue border on focus */
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25); /* Blue shadow on focus */
}

button[type="submit"] {
    background-color: #007bff; /* Blue button */
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease; /* Smooth hover transition */
}

button[type="submit"]:hover {
    background-color: #0056b3; /* Darker blue on hover */
}
</style>
