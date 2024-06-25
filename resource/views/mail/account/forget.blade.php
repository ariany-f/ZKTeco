<!DOCTYPE html>
<html lang="{{ config('app.lang') }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} | Recuperação de senha</title>
    <style>
        @font-face {
            font-family: 'Montserrat';
            src: url('https://fonts.googleapis.com/css?family=Montserrat:400,500,700');
            font-weight: normal;
            font-style: normal;
        }
        body {
            font-family: 'Montserrat', Arial, sans-serif;
        }
    </style>
</head>
<body>
    <h2 style="margin-bottom: 20px;">{{ config('app.name') }} - Recuperação de senha</h2>

    <section style="margin-bottom: 40px;">
        <div style="padding: 20px; border: 1px solid #bfbfbf; border-radius: 5px;">
            <p style="margin-bottom:40px;">Para recuperar sua conta basta clicar no link abaixo:</p>
            <a href="{{ route('site.forget.password', ['token' => $client->token]) }}" title="Recuperar Senha" style="padding: 15px; border: none; text-decoration: none; background-color: rgb(19, 63, 141); color: white;">Recuperar Senha</a>
        </div>
    </section>
</body>
</html>