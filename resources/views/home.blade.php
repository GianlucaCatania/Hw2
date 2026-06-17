<!DOCTYPE html>
<html>
<head>
    <title>Home Provvisoria</title>
</head>
<body>
    <h1>BINGO! Sei atterrato nella Home!</h1>
    
    <h2>Benvenuto, {{ session('username') }}!</h2>
    
    <p>Se vedi il tuo nome qui sopra, il collegamento col DB hw2 è perfetto.</p>

    <a href="{{ url('login') }}">Torna al Login</a>

    <a href="{{ url('logout') }}">Effettua il Logout</a>
</body>
</html>