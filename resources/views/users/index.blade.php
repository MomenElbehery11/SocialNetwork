<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <form action="{{ route('users.search') }}" method="GET">
        <input type="text" name="query" placeholder="Search users...">
        <button type="submit">Search</button>
    </form>

    <title>All Users</title>
</head>
<body>
    <div>
    <h1>All Users</h1>

    @if ($users->isEmpty())
        <p>No users found.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Profile Picture</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td><img src="{{asset('storage/'.$user->image)}}" width="90" height="90" style="border-radius: 50%" alt="Profile Picture">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <a href="{{route('profile')}}" class="btn btn-warning" role="button">Profile Page</a>

    </div>
</body>
<style>
    body{
        background: rgb(106, 90, 205);
    }
    .p1{
        text-align: center;
    }
</style>
</html>
