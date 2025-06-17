<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Event Client</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light px-4">
        <a class="navbar-brand" href="{{ url('/events') }}">EventApp</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
             @if(session('api_token'))
                  
                    <li class="nav-item">
                  <form action="{{ route('logout') }}" method="POST" style="display: inline;">
    @csrf
    <button type="submit" class="btn btn-link">Logout</button>
</form></li>

                @else
               <li class="nav-item">  <a class="nav-link" href="{{ route('register') }}">Sign Up</a></li>

                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                @endif
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>
</body>
</html>
