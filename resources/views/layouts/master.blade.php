<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'AOL Chat')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Fogli di stile -->
    <link rel="stylesheet" href="{{ url('/') }}/css/bootstrap.min.css">

    <!-- jQuery e plugin JavaScript  -->
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="{{ url('/') }}/js/bootstrap.min.js"></script>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link href="{{ url('/') }}/css/style.css" rel="stylesheet">
</head>

<body class="aol-body">
    <nav class="navbar navbar-expand-lg aol-navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('chat.index')}}">AOL Chat</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="list-group-item aol-list-item" href="{{ route('chat.search')}}">New
                            Chat</a>
                    </li>
                </ul>

                @if (auth()->check())
                    <a class="nav-item nav-link">Welcome {{auth()->user()->name}}</a>
                    <form method="POST" action="{{ route('logout')}}">
                        @csrf
                        <button type="submit" class="btn btn-outline-light">
                            <i class=" bi bi-box-arrow-right"></i>
                        </button>
                    </form>
                    <a href="{{ route('settings.index')}}" class="btn btn-outline-light"><i class="bi bi-gear-fill"></i></a>

                @else

                    <a href="{{ route('login')}}" class="btn btn-outline-light"><i class="bi bi-person-gear"></i></a>

                @endif


            </div>
        </div>
    </nav>

    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-md-3 p-3 aol-sidebar">
                @yield('sidebar')
            </div>

            <div class="col-md-9 p-3">
                @yield('body')
            </div>
        </div>
    </div>
</body>

</html>