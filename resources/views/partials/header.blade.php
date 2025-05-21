<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container d-flex flex-column">
            <div class="row align-items-center mb-2 w-100">
                <div class="col-4">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="{{ asset('images/logo.png') }}" alt="logo" height="40">
                    </a>
                </div>
                <div class="col-8 d-flex align-items-center justify-content-end">
                    <a href="#" class="me-3 text-decoration-none text-dark fw-bold">
                        Kontakty a čísla na oddelenia
                    </a>

                    <form id="searchForm" class="d-flex me-3" role="search">
                        <input class="form-control me-2" type="search" placeholder="Hľadaj...">
                    </form>

                    <a href="#" class="btn btn-success">Prihlásenie</a>

                    <!-- Toggler button pre mobilné zobrazenie -->
                    <button class="navbar-toggler ms-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </div>

            <!-- Collapse menu -->
            <div class="row w-100">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav d-flex flex-row gap-3">
                        @foreach (config('navigation.header') as $link)
                            <li class="nav-item">
                                <a href="#" class="nav-link fw-bold">{{ $link['title'] }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>
