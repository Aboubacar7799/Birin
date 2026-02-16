@extends('base')

@section('title', 'À propos')

<!-- La barre de navigation -->
@include('navbar/navbar')
@include('navbar/mobile')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center text-center">

        <div class="col-12 col-md-10 col-lg-8">

            <h2 class="about-title">
                À propos de moi
            </h2>

            <p class="about-subtitle">
                Développeur web passionné spécialisé en 
                <strong>Laravel</strong> et <strong>Django</strong>.
            </p>

            <p class="about-description">
                Orienté vers la résolution de problèmes digitaux 
                et la création d’applications modernes, performantes 
                et évolutives.
            </p>

            <div class="cv-box mt-4">
                <p class="mb-3">
                    Vous pouvez télécharger mon CV pour en savoir plus 
                    sur mon parcours, mes compétences et mes expériences.
                </p>

                <a href="{{ asset('cv/Mon curriculum.pdf') }}" 
                   class="btn btn-primary btn-lg px-4" 
                   download>
                    Télécharger mon CV (PDF)
                </a>
            </div>

        </div>

    </div>
</div>
<style>
    .about-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 15px;
    background: linear-gradient(60deg, #0d6efd, #59001d);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.about-subtitle {
    font-size: 1.2rem;
    color: #6c757d;
    margin-bottom: 10px;
}

.about-description {
    font-size: 1rem;
    color: #555;
    line-height: 1.6;
}

.cv-box {
    background: #f8f9fa;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
}
</style>
@endsection