<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <title>@yield('title')</title>
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
          <a @class(['nav-link', 'active' => str_contains($route, 'property.')]) href="{{ route('property.index') }}">Biens</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<body>
  @yield('content')
  <script src="{{ asset('bootstrap/js/bootstrap.bundle.js') }}"></script>
</body>
</html>