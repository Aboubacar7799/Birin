@extends('base')

@section('title', 'Profile')

<link rel="stylesheet" href="{{ asset('assets/javaUser/profil.css') }}">

@include('navbar/navbar')
@include('navbar/mobile')

@section('content')

@include('layout/model_suppresion')

{{-- Le contenu de notre page profile --}}
    <div class="container mt-4">
        {{-- SECTION PROFIL --}}
        <div class="row align-items-center">

            {{-- Photo --}}
           <div class="col-12 col-md-4 text-center mb-3 mb-md-0">
                <div class="profile-avatar mx-auto
                    {{ $user->isOnline() ? 'online' : 'offline' }}">
                    <img src="{{ $user->profil->getImage() }}" alt="Photo de profil" class="profile-img">
                </div>
            </div>


            {{-- Infos --}}
            <div class="col-12 col-md-8" id="app">

                {{-- Nom + actions --}}
                <div class="d-flex flex-column flex-sm-row align-items-sm-center gap-2">

                    <h4 class="fw-bolder mb-0 nameUser">{{ $user->name }}</h4>

                        @if($user->id === auth()->id())
                            <div class="dropdown mb-3 ms-auto">
                                <button class="btn btn-light btn-sm" data-bs-toggle="dropdown">
                                    <img src="{{ asset('assets/svg/menu_3P.png') }}" class="img-fluid" alt="" width="30" height="30"/>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ route('app_account_delete_page') }}" class="dropdown-item">
                                            Supprimer mon compte
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        @endif

                    <div class="d-flex gap-2">
                        @if ($user->id !== auth()->id())
                        <a href="{{ route('app_conversations_show', $user->id) }}" class="btn btn-secondary btn-sm">
                          <i class="fa-solid fa-comment"></i> <span>Message</span>  
                        </a>
                            
                        @endif

                        <followbutton profil-id="{{ $user->profil->id }}" follows="{{ $follows }}"
                            auth-profil-id="{{ auth()->user()->profil->id }}" />
                    </div>

                </div>

                {{-- Stats --}}
                <div class="d-flex justify-content-start gap-4 mt-3 flex-wrap">

                    <div>
                        <a href="#publication" class="text-decoration-none">
                            <span class="fw-bold">{{ $postCount }}</span> publications
                        </a>
                    </div>

                    <div>
                        <a href="{{ route('app_relations_index', [
                            'user' => $user->id,
                            'tab' => 'followers',
                        ]) }}"
                            class="text-decoration-none">
                            <span class="fw-bold">{{ $followsCount }}</span> abonnés
                        </a>
                    </div>

                    <div>
                        <a href="{{ route('app_relations_index', [
                            'user' => $user->id,
                            'tab' => 'following',
                        ]) }}"
                            class="text-decoration-none">
                            <span class="fw-bold">{{ $followingCount }}</span> suivis
                        </a>
                    </div>

                </div>

                {{-- Bouton édition --}}
                @can('update', $user->profil)
                    <div class="mt-3">
                        <a href="{{ route('app_profil_edit', ['user' => $user->id]) }}"
                            class="btn btn-outline-secondary btn-sm">
                            Modifier mon profil
                        </a>
                    </div>
                @endcan

                {{-- Bio --}}
                <div class="mt-3">
                    <div class="fw-bolder">Biographie</div>
                    <div>{{ $user->profil->description }}</div>

                    @if ($user->profil->lien)
                        <a href="{{ $user->profil->lien }}" target="_blank">
                            {{ $user->profil->lien }}
                        </a>
                    @endif

                    @can('update', $user->profil)
                        <div class="mt-2">
                            <a class="btn btn-outline-primary btn-sm" href="{{ route('app_post_create') }}">
                                Créer une publication
                            </a>
                        </div>
                    @endcan
                </div>

            </div>
        </div>

        <hr class="my-4">

        {{-- PUBLICATIONS --}}
        @if (Session::has('success'))
            <div class="alert alert-success text-center fw-bold" role="alert">
                {{ Session::get('success') }}
            </div>
        @endif
        <div class="container mt-4" id="publication">
        @forelse ($user->posts as $post)
            <div class="row justify-content-center mb-4">
                <div class="col-md-8 col-lg-6">
                    <div class="card shadow-sm rounded-3" id="post-{{ $post->id }}">
                        {{-- HEADER --}}
                        <div class="card-body pb-2">
                            <div class="d-flex align-items-center">
                                <a href="{{ route('app_profil', ['user' => $post->user]) }}"
                                    class="d-flex align-items-center text-decoration-none text-dark">
                                    <img src="{{ $post->user->profil->getImage() }}" class="rounded-circle me-2"
                                        width="45" height="45">
                                    <div>
                                        <strong>{{ $post->user->name }}</strong><br>
                                        <small class="text-muted">
                                            {{ $post->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                </a>
                                 @if($post->user_id === auth()->id())
                                    <div class="dropdown mb-3 ms-auto">
                                        <button class="btn btn-light btn-sm" data-bs-toggle="dropdown">
                                            <img
                                                src="{{ asset('assets/svg/menu_3P.png') }}"
                                                class="img-fluid"
                                                alt=""
                                                width="30"
                                                height="30"
                                            />
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                @can('delete', $post)
                                                    <a href="#" 
                                                    class="dropdown-item delete-post-btn"
                                                    data-id="{{ $post->id }}">
                                                    Supprimer
                                                    </a>
                                                @endcan
                                            </li>
                                        </ul>
                                    </div>
                                @endif
                            </div>
                            <p class="mt-3 mb-2">
                                {{ $post->description }}
                            </p>
                        </div>
                        @php
                            $count = $post->images->count();
                            $class = match ($count) {
                            1 => 'images-1',
                            2 => 'images-2',
                            3 => 'images-3',
                            4 => 'images-4',
                            default => 'images-multiple'
                            }
                         @endphp
                        <div class="postImages {{ $class }}">
                            @foreach ($post->images->take(4) as $key => $image )
                            <div class="image-wrapper position-relative">
                                <a href="{{ route('app_affiche_image', ['post' => $post->id,'image' => $image->id]) }}" class="">
                                    <img src="{{ asset('storage/' . $image->image) }}" class="img-fluid w-100 h-100">
                                </a>
                                @if ($count > 4 && $key === 3)
                                    <div class="overlay">
                                        +{{ $count - 4 }}
                                    </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                        <div class="px-3 py-2 text-muted small d-flex justify-content-between">
                            <div id="counts-{{ $post->id }}">
                                <div>
                                    {{ $post->likes->count() }} likes
                                </div>
                                👍 {{ $post->likes->where('type', 'like')->count() }}
                                ❤️ {{ $post->likes->where('type', 'love')->count() }}
                                😢 {{ $post->likes->where('type', 'sad')->count() }}
                                😡 {{ $post->likes->where('type', 'angry')->count() }}
                                😮 {{ $post->likes->where('type', 'wow')->count() }}
                            </div>
                            <div>
                                {{ $post->comments->count() }} commentaires
                            </div>
                        </div>
                        <div class="d-flex justify-content-between px-3 py-2 border-top">
                            {{-- LIKE --}}
                            <div class="reaction-wrapper" data-post="{{ $post->id }}">
                                @php
                                    $reaction = $post->userLike()?-> type;
                                @endphp
                                <button type="button" class="btn btn-light btn-sm" id="btn-{{ $post->id }}">
                                    @switch($reaction)
                                        @case('love') ❤️ J'adore @break
                                        @case('sad') 😢 Triste @break
                                        @case('angry') 😡 Furieux @break
                                        @case('wow') 😮 Wouah @break
                                        @default 👍 J’aime
                                    @endswitch
                                </button>
                                <div class="reaction-options">
                                    @foreach (['like' => '👍', 'love' => '❤️', 'sad' => '😢', 'angry' => '😡', 'wow' => '😮'] as $type => $emoji)
                                        <span onclick="sendReaction('{{ $type }}', {{ $post->id }})">
                                            {{ $emoji }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                            {{-- COMMENTER --}}
                            <a href="{{ route('posts.comments', $post->id) }}" class="btn btn-light btn-sm"
                                data-post-id="{{ $post->id }}">
                                💬 Commenter
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center text-muted p-3">
                Bienvenue parmi nous sur la plateforme <strong class="text-danger">BIRIN</strong> <br>
                Pour accéder aux publications des utilisateurs, vous devez les suivre. <br>
                Explorez les profils dans onglet <strong class="text-info">"Mes amis"</strong> puis <strong class="text-info">"Découvrir"</strong>, cliquez sur <strong class="text-info">S'abonner</strong> pour voir leurs contenus dans votre fil d'actualité.
            </div>
        @endforelse
    </div>
    </div>
    <script>
        window.REACTION_URL = "{{ route('reaction.ajax') }}"
    </script>
    <script src="{{ asset('assets/javaUser/post.js')}}"></script>
@endsection
