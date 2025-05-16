<form action="{{ route('user.image.edit', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div>
        <label for="PP">Upload Profile Picture:</label>
        <input type="file" id="PP" name="PP" required>
    </div>
    <button type="submit">Upload</button>
</form>
<style>
    body {
        background: linear-gradient(to right, #f1f4f9, #dff1ff);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    form {
        max-width: 550px;
        margin: 50px auto;
        padding: 30px 40px;
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    form h2 {
        text-align: center;
        color: #4a00e0;
        margin-bottom: 25px;
    }

    label {
        display: block;
        margin-bottom: 6px;
        color: #333;
        font-weight: 600;
    }

    input[type="file"] {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 14px;
        margin-bottom: 20px;
        transition: border-color 0.3s ease;
    }

    input[type="file"]:focus {
        border-color: #7f00ff;
        outline: none;
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
