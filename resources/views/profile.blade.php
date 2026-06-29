@extends('layouts.auth')

@section('title', 'Profilo di ' . $user->name)

@section('styles')
    <link rel="stylesheet" href="{{ url('style_profile.css') }}">
@endsection

@section('scripts')
    <script src="{{ url('script_profile.js') }}" defer></script>
    <script>
        const check_username_url = "{{ url('check_username_profile') }}";
        const check_email_url = "{{ url('check_email_profile') }}";
    </script>
@endsection

@section('content')

    <header>
        <nav>
            <div id="logo">
                <a href="{{ url('home') }}">KFC</a>
            </div>

            <div id="links">
                <a href="{{ url('home') }}">HOME</a>
                <a href="{{ url('cart') }}">CARRELLO</a>
                <a href="{{ url('logout') }}" id="button">LOGOUT</a>
            </div>
        </nav>
    </header>

    <div class="userInfo">
        <h1>Il tuo profilo</h1>
    </div>

    <form id="form" name='profile' method='post' action="{{ url('profile') }}">
        @csrf

        <div class="col-left column">
            <div class="name">
                <label for='name'>NOME</label>
                <input type='text' id='name' name='name' value="{{ old('name', $user->name) }}">
            </div>
            
            <div class="surname">
                <label for='surname'>COGNOME</label>
                <input type='text' id='surname' name='surname' value="{{ old('surname', $user->surname) }}">
            </div>

            <div class="username">
                <label for='username'>NOME UTENTE</label>
                <input type='text' id='username' name='username' value="{{ old('username', $user->username) }}">
            </div>
        </div>

        <div class="col-right column">
            <div class="email">
                <label for='email'>EMAIL</label>
                <input type='text' id='email' name='email' value="{{ old('email', $user->email) }}">
            </div>
            
            <div class="old-password">
                <label for='old_password'>VECCHIA PASSWORD</label>
                <input type='password' id='old_password' name='old_password'>
            </div>

            <div class="password">
                <label for='password'>PASSWORD</label>
                <input type='password' id='password' name='password'>
            </div>
            
            <div class="confirm_password">
                <label for='confirm_password'>CONFERMA PASSWORD</label>
                <input type='password' id='confirm_password' name='confirm_password'>
            </div>
        </div>

        <div class="error-line hidden"><span></span></div>

        @if(isset($errors))
            @foreach($errors->all() as $error)
                <div class='error-line server-error'><span>{{ $error }}</span></div>
            @endforeach
        @endif

        @if(isset($success))
            <div class='success-line'><span>{{ $success }}</span></div>
        @endif

        <input type="submit" value='SALVA MODIFICHE' id="submit">
    </form>
@endsection