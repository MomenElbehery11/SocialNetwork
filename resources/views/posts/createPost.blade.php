<form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label for="body">enter new post</label><br>
    <textarea name="body" rows="5" cols="30"></textarea><br><br>

    <label for="image">Image:</label><br>
    <input type="file" name="image"><br><br>

    <button type="submit">Save</button>
</form>
<style>
    form {
        max-width: 500px;
        margin: 40px auto;
        padding: 30px;
        border: 1px solid #ddd;
        border-radius: 12px;
        background-color: #f9f9f9;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        font-family: Arial, sans-serif;
    }

    label {
        font-weight: bold;
        display: block;
        margin-bottom: 8px;
        color: #333;
    }

    textarea,
    input[type="file"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 14px;
        box-sizing: border-box;
    }

    button {
        background-color: #4CAF50;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #45a049;
    }
</style>
