@extends('base')

@section('title', 'Tous nos biens')

@section('content')

<div class="bg-light p-5 mb-5 text-center">
    @include('shared.flash')
    <form action="" method="get" class="container d-flex gap-2">
        <input type="number" name="price" placeholder="Budget max" class="form-control" value="{{ $input['price'] ?? '' }}">
        <input type="number" name="surface" placeholder="Surface minimale" class="form-control" value="{{ $input['surface'] ?? '' }}">
        <input type="number" name="rooms" placeholder="Nombre de pièce" class="form-control" value="{{ $input['rooms'] ?? '' }}">
        <input name="title" placeholder="Mot clef" class="form-control" value="{{ $input['title'] ?? '' }}">
        <button class="btn btn-primary btn-sm flex-grow-0">
            Rechercher
        </button>
    </form>
</div>

<div class="container">
    <h1 class="text-center">@yield('title')</h1>
    <div class="row mt-4">
        @forelse($properties as $property)
            <div class="col-3 mb-4">
                @include('property.card')
            </div>
        @empty
        <div class="col fs-1 text-dark mt-5 text-center">
            Aucun bien ne correspond à votre recherche!!!
        </div>
        @endforelse
    </div>
    <div class="my-4">
        {{ $properties->links() }}
    </div>
</div>


@endsection