<h2>Enter The New Name :</h2>
<form action="{{ route('user.name.edit', Auth::user()->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label for="name">Name:</label><br>
    <input type="name" name="name" id="">

    <button type="submit">Save</button>
</form>
<style>
    .edit-email-container {
        background-color: #fff; /* White background */
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15); /* More pronounced shadow */
        width: 90%;
        max-width: 400px;
        margin: 30px auto;
        text-align: center; /* Center the heading */
    }

    h2 {
        color: #343a40; /* Dark gray heading text */
        margin-bottom: 20px;
        font-size: 1.75rem;
    }

    form {
        display: flex; /* Arrange label, input, and button in a row */
        flex-direction: column; /* Stack elements vertically on smaller screens */
        align-items: stretch; /* Make elements take full width */
    }

    label {
        font-weight: 600; /* Semi-bold label */
        color: #495057;
        margin-bottom: 8px;
        text-align: left; /* Align label to the left */
    }

    input[type="name"] {
        padding: 12px;
        margin-bottom: 15px;
        border: 1px solid #ced4da;
        border-radius: 6px;
        font-size: 1rem;
    }

    input[type="name"]:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    button[type="submit"] {
        background-color: #28a745; /* Green save button */
        color: white;
        padding: 12px 25px;
</style>
