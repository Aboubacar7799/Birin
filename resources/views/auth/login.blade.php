@extends('base')

@section('title','Login')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-5 mx-auto">
                <h1 class="text-center text-muted mb-3 mt-5">AUTHENTIFICATION</h1>
                <div class="d-flex justify-content-center mb-3">
                    <img src="{{ asset('assets/svg/birin.png') }}" width="100" height="100" class="text-center">
                </div>
                {{-- on inclu le fichier qui contient les erreurs de toutes categorie --}}
                @include('alerts.alert-message')

                <form method="POST" action="{{ route('login')}}">
                    @csrf
                    @error('email')
                        <div class="alert alert-danger text-center" role="alert">
                            Login ou mot de passe incorrect
                        </div>
                    @enderror

                    @error('password')
                        <div class="alert alert-danger text-center" role="alert">
                            Login ou mot de passe incorrect
                        </div>
                    @enderror

                    <label class="form-label" for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control mb-3" value="{{old('email')}}" placeholder="email" autocomplete="email" autofocus required>

                    <label class="form-label" for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control mb-3" placeholder="Password" required>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="souvener" id="souvener" role="switch" value="{{ old('souvener') ? 'checked' :'' }}">
                                <label for="souvener" class="form-check-label">souvener de moi</label>
                            </div>
                        </div>

                        <div class="col-md-6 text-end">
                        <a href="{{ route('app_password_oublier') }}">mot de passe oublié</a>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Se connecté</button>
                    </div>

                    <p class="text-muted text-center mt-5">Tu n'as pas de compte ? <a href="{{ route('register')}}">S'inscrire</a></p>
                </form>
            </div>
        </div>
    </div>
@endsection
