@extends('base')

@section('title', 'Suppression du Compte')

@include('navbar/navbar')
@include('navbar/mobile')

@section('content')
<div id="app">
    <h3>Supprimer mon compte</h3>
    <deleteaccount />
</div>
@endsection