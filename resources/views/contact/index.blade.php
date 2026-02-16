@extends('base')

@section('title', 'Contact')

<!-- La barre de navigation -->
@include('navbar/mobile')
@include('navbar/navbar')

@section('content')
    <div class="container mt-4">

        <div class="row justify-content-center text-center mb-5">
            <div class="col-12 col-md-10 col-lg-8">

                <h2 class="contact-title">
                    Contactez-moi
                </h2>

                <p class="contact-subtitle">
                    Avez-vous un projet, une opportunité ou une question à me poser ?
                </p>

                <p class="contact-description">
                    N'hésitez pas à me contacter via l’un de ces réseaux sociaux 
                    ou à consulter mon <strong>curriculum vitae</strong> dans l’onglet 
                    <span class="highlight"> <a href="{{ route('app_about') }}" class="text-decoration-none">À propos</a> </span>.
                </p>

            </div>
        </div>

        <div class="contact-list row">
            <div class="col-12 col-md-6 col-lg-4 mb-3">
                {{-- WhatsApp --}}
                <a href="https://wa.me/224625423650?text=Bonjour%20je%20souhaite%20vous%20contacter" target="_blank"
                    class="contact-item whatsapp">
                    <div class="left">
                        <i class="fa-brands fa-whatsapp fa-lg me-3"></i>
                        <span>WhatsApp</span>
                    </div>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
            <div class="col-12 col-md-6 col-lg-4 mb-3">
                {{-- Email Gmail --}}
                <a href="https://mail.google.com/mail/?view=cm&fs=1&to=fodeaboubacar1997@email.com&su=Contact&body=Bonjour"
                    target="_blank" class="contact-item email">
                    <div class="left">
                        <i class="fa-solid fa-envelope fa-lg me-3"></i>
                        <span>Email</span>
                    </div>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <div class="col-12 col-md-6 col-lg-4 mb-3">
                {{-- Facebook Messenger --}}
                <a href="https://m.me/aboubacarfobic.camara.73325" target="_blank" class="contact-item messenger">
                    <div class="left">
                        <i class="fa-brands fa-facebook-messenger fa-lg me-3"></i>
                        <span>Messenger</span>
                    </div>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <div class="col-12 col-md-6 col-lg-4 mb-3">
                {{-- Instagram --}}
                <a href="https://www.instagram.com/direct/t/aboubacarfobic.camara.73325/" target="_blank"
                    class="contact-item instagram">
                    <div class="left">
                        <i class="fa-brands fa-instagram fa-lg me-3"></i>
                        <span>Instagram</span>
                    </div>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <div class="col-12 col-md-6 col-lg-4 mb-3">
                {{-- LinkedIn --}}
                <a href="https://www.linkedin.com/in/fode-aboubacar-camara-84a624378/" target="_blank"
                    class="contact-item linkedin">
                    <div class="left">
                        <i class="fa-brands fa-linkedin fa-lg me-3"></i>
                        <span>LinkedIn</span>
                    </div>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <div class="col-12 col-md-6 col-lg-4 mb-3">
                {{-- Telegram --}}
                <a href="https://t.me/@Wizbut?text=Bonjour%20je%20souhaite%20vous%20contacter" target="_blank"
                    class="contact-item telegram">
                    <div class="left">
                        <i class="fa-brands fa-telegram fa-lg me-3"></i>
                        <span>Telegram</span>
                    </div>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <div class="col-12 col-md-6 col-lg-4 mb-3">
                <a href="tel:+224625423650" class="contact-item phone">
                    <div class="left">
                        <i class="fa-solid fa-phone fa-lg me-3"></i>
                        <span>Appel téléphonique</span>
                    </div>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <div class="col-12 col-md-6 col-lg-4 mb-3">
                <a href="sms:+224625423650" class="contact-item message">
                    <div class="left">
                        <i class="fa-solid fa-message fa-lg me-3"></i>
                        <span>Envoyer un SMS</span>
                    </div>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
            </div>

        </div>

    </div>

    <style>
            .contact-title {
            font-size: 2.5rem;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 15px;
            background: linear-gradient(60deg, #0d6efd, #59001d);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .contact-subtitle {
            font-size: 1.2rem;
            color: #6c757d;
            margin-bottom: 10px;
        }

        .contact-description {
            font-size: 1rem;
            color: #555;
        }

        .highlight {
            color: #0d6efd;
            font-weight: 600;
        }
        </style>
@endsection
