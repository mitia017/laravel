@extends('base')
@section('title', 'Agence')
@section('content')

<div class="bg-light p-5 mb-5 text-center">
    <div class="container">
        <h1>Agence Immobilier</h1>
        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Facilis veniam, vero voluptates labore tempora autem atque inventore iste itaque minus dolor ea est soluta ducimus voluptatem doloremque, ipsum dolorem quam!</p>
    </div>
</div>
<div class="container">
    <h2>Nos derniers biens</h2>
    <div class="row">
        @foreach($properties as $property)
            <div class="col">
                @include('property.card')
            </div>
        @endforeach
    </div>
</div>

@endsection