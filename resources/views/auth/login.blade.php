@extends('base')

@section('title', 'Se Connecter')

@section('content')

    <div class="mt-4 container w-25" style="height:100%;">
        @include('shared.flash')
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">@yield('title')</h1>
                <form class="vstack gap-2" action="{{ route('login') }}" method="post">
                    @csrf
                    @include('shared.input', ['label' => 'Email', 'name' => 'email', 'type' => 'email', 'class' => 'col'])
                    @include('shared.input', ['label' => 'Mot de passe', 'name' => 'password', 'type' => 'password', 'class' => 'col'])
                    <div>
                        <button class="btn btn-primary">Se connecter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

