
@extends('layouts.app')

@section('title', 'Profilo di ' . $user->name)

@section('scripts')
    <link rel="stylesheet" href="{{ asset('style_profile.css') }}">
    <script src="{{ asset('script_profile.js') }}" defer></script>
@endsection

@section('content')
    <div class="userInfo">
        <h1>Il tuo profilo</h1>
    </div>

    <form name='profile' method='post' action="{{ url('profile') }}">
        @csrf

        <div class="col-left">
            <div class="name">
                <label for='name'>NOME</label>
                {{-- Usiamo {{ $var }} invece di echo --}}
                <input type='text' name='name' value="{{ old('name', $user->name) }}">
            </div>
            
            <div class="surname">
                <label for='surname'>COGNOME</label>
                <input type='text' name='surname' value="{{ old('surname', $user->surname) }}">
            </div>

            <div class="username">
                <label for='username'>NOME UTENTE</label>
                <input type='text' name='username' value="{{ old('username', $user->username) }}">
            </div>
        </div>

        <div class="col-right">
            <div class="email">
                <label for='email'>EMAIL</label>
                <input type='text' name='email' value="{{ old('email', $user->email) }}">
            </div>
            
            <div class="old-password">
                <label for='old_password'>VECCHIA PASSWORD</label>
                <input type='password' name='old_password'>
            </div>

            <div class="password">
                <label for='password'>PASSWORD</label>
                <input type='password' name='password'>
            </div>
            
            <div class="confirm_password">
                <label for='confirm_password'>CONFERMA PASSWORD</label>
                <input type='password' name='confirm_password'>
            </div>
        </div>

        <div class="error-line hidden"><span></span></div>

        @if(session('error'))
            <div class='error-line'><span>{{ session('error') }}</span></div>
        @endif

        @if(session('success'))
            <div class='success-line'><span>{{ session('success') }}</span></div>
        @endif

        <input type="submit" value='SALVA MODIFICHE' id="submit">
    </form>
@endsection