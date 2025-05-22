<header class="section-header">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo">
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#hamNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-end" id="hamNav">
                    <ul class="navbar-nav d-flex align-items-center gap-2">
                        <li class="nav-item"><a class="nav-link fw-bold text-primary" href="#">Kontakty a čísla na oddelenia</a></li>
                        <li class="nav-item">
                            <select class="form-select form-select-sm">
                                <option value="sk">SK</option>
                                <option value="en">EN</option>
                            </select>
                        </li>
                        <li class="nav-item">
                            <input type="text" class="form-control form-control-sm">
                        </li>
                        <li class="nav-item">
                            <a href="#" class="btn btn-success btn-sm">Prihlásenie</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <nav class="mt-2">
            <ul class="navbar-nav d-flex flex-row gap-4">
                @foreach (config('navigation.header') as $link)
                    <li class="nav-item">
                        <a href="#" class="nav-link main-nav">{{ $link['title'] }}</a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
</header>