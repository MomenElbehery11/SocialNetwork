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

    textarea,
    input[type="file"] {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 14px;
        margin-bottom: 20px;
        transition: border-color 0.3s ease;
    }

    textarea:focus,
    input[type="file"]:focus {
        border-color: #7f00ff;
        outline: none;
    }

    button {
        display: block;
        width: 100%;
        background: linear-gradient(to right, #7f00ff, #e100ff);
        color: white;
        padding: 14px;
        font-size: 16px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    button:hover {
        background: linear-gradient(to right, #6a00cc, #c000cc);
    }
</style>
