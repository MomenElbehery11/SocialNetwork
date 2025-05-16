<h1>Search Results</h1>

<ul>
    @foreach ($users as $user)
        <li>{{ $user->name }} - {{ $user->email }}</li>
        <img src="{{asset('storage/'. Auth::user()->image)}}" width="130" height="130" style="border-radius: 50%" alt="Profile Picture">
    @endforeach
</ul>
<style>
    body {
        background: linear-gradient(to right, #f1f4f9, #dff1ff);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    h1 {
        text-align: center;
        color: #4a00e0;
        margin-bottom: 25px;
    }

    ul {
        list-style-type: none;
        padding: 0;
    }

    li {
        background-color: #fff;
        padding: 15px;
        margin: 10px 0;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
</style>
