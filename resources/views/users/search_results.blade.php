<h1>Search Results</h1>

<ul>
    @foreach ($users as $user)
        <li>{{ $user->name }} - {{ $user->email }}</li>
        <img src="{{asset('storage/'. Auth::user()->image)}}" width="130" height="130" style="border-radius: 50%" alt="Profile Picture">
    @endforeach
</ul>
