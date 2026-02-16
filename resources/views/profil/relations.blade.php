@extends('base')

@section('title','Mes Relations')

<!-- La barre de navigation -->
@include('navbar/navbar')
@include('navbar/mobile')

@section('content')
    <div class="container mt-5" id="app">
    <ul class="nav nav-tabs" id="followTab" role="tablist">
        {{-- Ajoute cet onglet dans ta liste <ul> --}}
        <li class="nav-item">
            <button class="nav-link {{ $tab === 'discover' ? 'active' : '' }} " id="discover-tab" data-bs-toggle="tab" data-bs-target="#discover">
                Découvrir ({{ $allUsers->count() }})
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link {{ $tab === 'followers' ? 'active' : '' }}" id="followers-tab" data-bs-toggle="tab" data-bs-target="#followers">
                Abonnés ({{ $user->profil->followers->count() }})
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link {{ $tab === 'following' ? 'active' : '' }}" id="following-tab" data-bs-toggle="tab" data-bs-target="#following">
                Suivis ({{ $user->following->count() }})
            </button>
        </li>

    </ul>

    <div class="tab-content mt-3">

        {{-- Ajoute ce contenu dans ta <div class="tab-content"> --}}
        <div class="tab-pane fade {{ $tab === 'discover' ? 'show active' : '' }}" id="discover">
            <h5 class="my-3">Suggestions pour vous</h5>
            @foreach($allUsers as $registeredUser)
                <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                    <a href="{{ route('app_profil',['user' =>$registeredUser->id]) }}" class="text-decoration-none">
                        <div class="d-flex align-items-center">
                            {{-- Sécurité Image --}}
                            <img src="{{ $registeredUser->profil ? $registeredUser->profil->getImage() : 'https://ui-avatars.com/api/?name=' . urlencode($registeredUser->name) }}" 
                                width="45" height="45" class="rounded-circle me-3">
                            
                            <div>
                                <span class="fw-bold d-block">{{ $registeredUser->name }}</span>
                                <small class="text-muted">Inscrit {{ $registeredUser->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </a>

                    {{-- Sécurité Bouton Suivre --}}
                    @if($registeredUser->profil)
                        <followbutton
                            profil-id="{{ $registeredUser->profil->id }}" 
                            follows="{{ auth()->user()->following->contains($registeredUser->profil->id) }}" />
                    @else
                        <span class="badge bg-light text-dark">Profil incomplet</span>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="tab-pane fade show {{ $tab === 'followers' ? 'show active' : '' }}" id="followers">
            @foreach($user->profil->followers as $follower)
            <div class="d-flex align-items-center justify-content-between mb-3 p-2 border-bottom">
                <a href="{{ route('app_profil',['user' =>$follower->id]) }}" class="text-decoration-none">
                <div class="d-flex align-items-center">
                    <img src="{{ $follower->profil->getImage() }}" class="rounded-circle me-3" width="50" height="50">
                    <span class="fw-bold">{{ $follower->name }}</span>
                </div>
                {{-- Ton composant Vue pour suivre/ne plus suivre --}}
                </a>
                <followbutton profil-id="{{ $follower->profil->id }}" follows="{{ auth()->user()->following->contains($follower->profil->id) }}" />
            </div>
            @endforeach
        </div>

        <div class="tab-pane fade {{ $tab === 'following' ? 'show active' : '' }}" id="following">
            @foreach($user->following as $followedProfil)
            <div class="d-flex align-items-center justify-content-between mb-3 p-2 border-bottom">
                <a href="{{ route('app_profil',['user' =>$followedProfil->user->id]) }}" class="text-decoration-none">
                    <div class="d-flex align-items-center">
                        <img src="{{ $followedProfil->user->profil ? $followedProfil->getImage() : 'avatars/default1.jpg' }}" class="rounded-circle me-3" width="50" height="50">
                        <span class="fw-bold">{{ $followedProfil->user->name }}</span>
                    </div>
                </a>
                <followbutton profil-id="{{ $followedProfil->id }}" follows="true" />
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection