@extends('base')

@section('title','Profil')

<!-- La barre de navigation -->
@include('navbar/navbar')
@include('navbar/mobile')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-4">
                <h3 class="fw-bold">{{ $post->user->name }}</h3>
                <p>{{ $post->description }}</p>
            </div>
            <div class="">
                <a href="{{ asset('storage/'.$image->image) }}">
                    <img src="{{ asset('storage'). '/' .$image->image }}" class="" width="400" height="400" alt="">
                </a>
            </div>
            
        </div>
    </div>
@endsection
