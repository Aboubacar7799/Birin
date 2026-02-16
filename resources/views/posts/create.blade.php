@extends('base')

@section('title','Publication')

<!-- La barre de navigation -->
@include('navbar/navbar')
@include('navbar/mobile')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-5 mx-auto">
                <h1 class="text-center text-muted mb-3 mt-4">Créer une publication</h1>

                <form method="POST" action="{{ route('app_post_store')}}" class="row g-3" id="form-post" enctype="multipart/form-data">
                    @csrf

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="desc" class="form-label">Description</label>
                            <textarea class="form-control @error('desc') is-invalid @enderror" id="desc" rows="3" name="desc" id="desc" value="{{ old('desc')}}" placeholder="ecrire quelque sur toi ici..."  autocomplete="desc"></textarea>
                        </div>

                        @error('desc')
                            <small class="invalid-feedback fw-bold" role="alert">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <div class="input-group custom-file mb-3">
                            <label class="input-group-text custom-file-label" for="image" title="choisir une image">Choisir une image</label>
                            <input type="file" name="images[]" id="image" class="form-control custom-file-input @error('image') is-invalid @enderror" title="choisir une image" multiple required>

                            @error('image')
                                <small class="invalid-feedback fw-bold" role="alert">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary" id="publi-post">Publier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
