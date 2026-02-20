<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('tomSelect/bootstrap.css') }}">
    <script src="{{ asset('tomSelect/select.js') }}"></script>
    <title>@yield('title') | Administration</title>
</head>
<nav class="navbar navbar-expand-lg bg-primary navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand text-white" href="/">Agence</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    @php
        $route = request()->route()->getName();
    @endphp

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a @class(['nav-link', 'active' => str_contains($route, 'property.')]) href="{{ route('admin.property.index') }}">Gestion des biens</a>
        </li>
        <li class="nav-item">
          <a @class(['nav-link', 'active' => str_contains($route, 'option.')]) href="{{ route('admin.option.index') }}">Gestion des options</a>
        </li>
      </ul>
      <div class="ms-auto">
        @auth
          <ul class="navbar-nav">
            <li class="nav-item">
              <form action="{{ route('logout') }}" method="post">
                @csrf
                @method('delete')
                <button class="nav-link">Se déconnecter</button>
              </form>
            </li>
          </ul>
        @endauth
      </div>
    </div>
  </div>
</nav>
<body>
    <div class="container mt-5">
        @include('shared.flash')
        @yield('content')
    </div>
    <script>
      new TomSelect('select[multiple]', {plugins: {remove_button: {title: 'Supprimer'}}})
    </script>

    <script src="{{ asset('bootstrap/js/bootstrap.bundle.js') }}"></script>
</body>
</html>