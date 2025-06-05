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
            <a class="navbar-brand btn" href="{{ route('chat.index')}}">AOL Chat</a>

            @if (auth()->check())
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">

                    <ul class="navbar-nav me-auto">
                        <li class="nav-item"><a class="nav-link" href="{{ route('chat.search')}}">[New Chat]</a>
                        </li>
                        @yield('navbar')
                    </ul>



                    {{-- Cambia il welcome se è admin o no --}}
                    <a class="nav-item nav-link">
                        {{ auth()->user()->role == 'admin' ? 'Welcome Admin' : 'Welcome' }} {{ auth()->user()->name }}
                    </a>


                    <a href="{{ route('settings.index')}}" class="btn aol-btn"><i class="bi bi-gear-fill"></i></a>

                    <form method="POST" action="{{ route('logout')}}">
                        @csrf
                        <button type="submit" class="btn aol-btn">
                            <i class=" bi bi-box-arrow-right"></i>
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </nav>

    <!-- Bottone per aprire sidebar (visibile solo su dispositivi piccoli e se loggato) -->
    @if (auth()->check())
        <button class="btn btn-primary d-md-none m-3 aol-btn" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#sidebarOffcanvas">
            <i class="bi bi-list"></i>
        </button>
    @endif

    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Sidebar come offcanvas per mobile, normale per desktop -->
            <div class="offcanvas-md offcanvas-start col-md-3 p-2 aol-sidebar" tabindex="-1" id="sidebarOffcanvas">
                <div class="offcanvas-header d-md-none">
                    <button type="button" class="btn-close text-reset aol-btn" data-bs-dismiss="offcanvas"
                        data-bs-target="#sidebarOffcanvas" aria-label="Close"></button>
                </div>
                <div class="p-0">
                    @yield('sidebar')
                </div>
            </div>

            <!-- Contenuto principale -->
            <div class="col-md-9 p-3">
                @yield('body')
            </div>
        </div>
    </div>


</body>

</html>