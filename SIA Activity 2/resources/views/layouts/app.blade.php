<!DOCTYPE html>
<html>
<head>
    <title>Retro Sneaker System</title>
    <style>
        body { font-family: 'Arial', sans-serif; background: #121212; color: white; padding: 40px; }
        .container { max-width: 800px; margin: auto; background: #1e1e1e; padding: 20px; border-radius: 10px; border: 2px solid #ff4500; }
        header { text-align: center; border-bottom: 2px solid #ff4500; margin-bottom: 20px; }
        a { color: #ff4500; text-decoration: none; font-weight: bold; }
        .btn { display: inline-block; background: #ff4500; color: white; padding: 10px 20px; border-radius: 5px; margin-top: 20px; }
        footer { margin-top: 40px; text-align: center; font-size: 0.8em; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>👟 RARE RETRO SNEAKERS</h1>
        </header>

        @yield('content')

    
    </div>
</body>
</html>