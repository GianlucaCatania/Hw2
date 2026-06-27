<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>KFC - @yield('title')</title>

        @yield('styles')
        @yield('scripts')
    </head>
    <body>
        
        <header>
            <div class="top-links">
                <div class="top-links-left">
                    <a href="#">Il mondo KFC</a>
                    <a href="#">Lavora con noi</a>
                    <a href="#">Diventa franchisee</a>
                </div>
                <div class="user-links">
                    @if(session('user_id') != null)
                        <a href="{{ url('profile') }}" id='account-label'>Profilo ({{ session('username') }})</a>
                        <a href="{{ url('logout') }}" id='logout-label'>Esci dalla sessione</a>
                    @else
                        <a href="{{ url('login') }}" id='account-label'>Login</a>
                        <a href="{{ url('register') }}" id='logout-label'>Register</a>
                    @endif
                </div>
            </div>

            <nav class="main-nav">
                <div class="container-nav">
                    <div class="main-nav-left-group">
                        <div class="logo">
                            <a href = "{{ url('home') }}"><img src="{{ url('img/logo.png') }}"></a>
                        </div>

                        <div class="nav-menu">
                            <a href="#">Prodotti</a>
                            <a href="#">Novità</a>
                            <a href="#">App</a>
                            <a href="#">Delivery</a>
                        </div>
                    </div>

                    <div class="nav-actions">
                        <div class="find-img">
                            <img src="{{ url('img/icon-location.png') }}">
                        </div>
                        <a href="#">Trova un ristorante</a>
                        <a href="{{ url('cart') }}" id="order-link">ORDINA ORA</a>

                        <div class="mobile-menu">
                            @if(session('user_id') != null)
                                <a href="{{ url('profile') }}" id="account-img"><img src="{{ url('img/account.png') }}"></a>
                                <a href="{{ url('logout') }}" id="logout-img"><img src="{{ url('img/logout.png') }}"></a>
                            @else
                                <a href="{{ url('login') }}" id="account-img"><img src="{{ url('img/account.png') }}"></a>
                            @endif
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        @yield('content')

        <div class="pre-footer">
            <section class="column-one">
                <a href="#">Info nutrizionali e allergeni</a><br>
                <a href="#">Press</a><br>
                <a href="#">Area riservata franchisee</a><br>
            </section>

            <section class="column-two">
                <a href="#">FAQ</a><br>
                <a href="#">Contatta l'assistenza</a><br>
            </section>

            <section class="column-three">
                <p id="newsletter-text">Iscriviti alla newsletter</p>

                <div class="fake-textbox-container">
                    <div class="fake-input-area">
                        <p>La tua email</p>
                    </div>
                    <div class="fake-button-area">
                        <p>ISCRIVITI</p>
                    </div>
                </div>

                <div class="privacy-checkbox">
                    <img src="{{ url('img/check_box_unchecked.png') }}">
                    <p>Ho preso visione <a href="#">dell'informativa privacy</a>*</p>
                </div>
            </section>
        </div>

        <footer>
            <div class="social-icons">
                <p>Seguici su</p>
                <a href="#"><img src="{{ url('img/facebook.png') }}"></a>
                <a href="#"><img src="{{ url('img/instagram.png') }}"></a>
                <a href="#"><img src="{{ url('img/youtube.png') }}"></a>
                <a href="#"><img src="{{ url('img/tiktok.png') }}"></a>
                <a href="#"><img src="{{ url('img/linkedin.png') }}"></a>
            </div>

            <div class="final-links">
                <a href="#">Privacy Policy</a>
                <a href="#">Termini e Condizioni</a>
                <a href="#">Compliance</a>
                <a href="#">Regolamenti</a>
                <a href="#">Accessibilità</a>
                <a href="#">Profilo</a>
                <p>@ 2026 KFC Italia. Tutti i diritti riservati</p>
            </div>

            <div class="footer-info-one">
                <p>Company of Bucket S.r.l. a socio unico - Sede legale: Viale Bodio 29/A, Bodio Center, Edificio La Vela, 20158</p>
                <p>Codice fiscale, partita IVA e numero di iscrizione al Registro delle Imprese di Milano: 08283010968</p>
            </div>

            <div class="footer-info-two">
                <p>Company of Bucket S.r.l., sensibile all'esigenza di garantire e promuovere condizioni di correttezza e
                    trasparenza nella conduzione degli affari e delle attività aziendali, oltre l'adozione del 
                    <a href="#">Global Code of Conduct di gruppo</a> ha ritenuto opportuno procedere alla definizione e
                    attuazione del <a href="#">Modello di Organizzazione, Gestione e Controllo ex D.Lgs.231/2001</a>
                    (Modello di Organizzazione)</p>
            </div>
        </footer>

        
    </body>
</html>