@extends('layouts.app')
@section('title', 'Registrati')

@section('scripts')
    <link rel='stylesheet' href="{{ url('style_register.css') }}">
    <script src="{{ url('script_register.js') }}" defer></script>
    <script>
        const check_username_url = "{{ url('check_username') }}";
        const check_email_url = "{{ url('check_email') }}";
    </script>
@endsection

@section('header')
    <div id="logo">
        <a href="{{ url('home') }}">KFC</a>
    </div>
@endsection

@section('content')
    <div id="container">
        <h1>CREA ACCOUNT</h1>
        
        <form name='signup' method='post' action="{{ url('register') }}">
            @csrf
            
            <div class="form-columns">
                <div class="col-left">
                    <div class="name">
                        <label for='name'>NOME</label>
                        <input type='text' id='name' name='name'>
                    </div>
                    
                    <div class="surname">
                        <label for='surname'>COGNOME</label>
                        <input type='text' id='surname' name='surname'>
                    </div>

                    <div class="username">
                        <label for='username'>NOME UTENTE</label>
                        <input type='text' id='username' name='username'>
                    </div>
                </div>

                <div class="col-right">
                    <div class="email">
                        <label for='email'>EMAIL</label>
                        <input type='text' id='email' name='email'>
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
            </div>

            <div class="allow"> 
                <input type='checkbox' name='allow' value="1" id="allow_check">
                <label for='allow_check'>ACCETTO I TERMINI E CONDIZIONI D'USO DI KFC.</label>
            </div>
            
            @if (isset($error))
                @foreach ($error as $err)
                    <div class='error-line'><span>{{$err}}</span></div>
                @endforeach
            @endif

            <div class="error-line hidden"><span></span></div>
            
            <div class="submit">
                <input type='submit' value="REGISTRATI" id="submit">
            </div>
        </form>
        
        <div class="login-link">HAI GIÀ UN ACCOUNT? <a href="{{ url('login') }}">ACCEDI</a></div>
    </div>
@endsection


