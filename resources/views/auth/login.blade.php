@extends('layouts.auth')
@section('title', 'Accedi')

@section('styles')
    <link rel='stylesheet' href="{{ asset('style_login.css') }}">
@endsection

@section('header')
    <div id="logo">
        <a href="{{ url('home') }}">KFC</a>
    </div>
@endsection

@section('content')
    <div class="login">
        <section>
            <h5>Per continuare, accedi a KFC.</h5>

            @if (isset($error))
                <p class='error'>{{ $error }}</p>
            @endif

            <form name='login' method='post' action="{{ url('login') }}">
                @csrf

                <div class="username">
                    <label for='username'>Username</label>
                    <input type='text' name='username'>
                </div>
                <div class="password">
                    <label for='password'>Password</label>
                    <input type='password' name='password'>
                </div>
                <div class="submit-container">
                    <div class="login-btn">
                        <input type='submit' value="ACCEDI">
                    </div>
                </div>
            </form>
            <div class="signup"><h4>Non hai un account?</h4></div>
            <div class="signup-btn-container"><a class="signup-btn" href="{{ url('register') }}">ISCRIVITI A KFC</a></div>
        </section>
    </div>
@endsection