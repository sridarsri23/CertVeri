<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}"></head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                @auth
    <div class="text-right">
                <li>
        <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-link">Logout</button>
        </form>
                </li>
    </div>
    <h2> {{auth()->user()->role}}</h2>
@endauth
                </ul>
            </div>
        </div>
    </nav>
  
    <div class="container">

        @yield('content')
    </div>

    <!-- ... -->
</body>
<footer class="welcome_footer">
        <span> CertV v.1.0 </span> - <span> by <a href="https://sridarsri.com"> Sridar | Sri </a></span>
    </footer>
</html>
