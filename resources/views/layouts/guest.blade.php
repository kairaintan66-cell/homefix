
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'HomeFix') }}</title>

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
          rel="stylesheet">

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            box-sizing: border-box;
        }

        html {
            min-height: 100%;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
            background: #f8faf9;
        }

        .auth-container {
            min-height: 100vh;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 30px;
        }

        .auth-container > * {
            width: 100%;
            max-width: 1050px;
            border-radius: 20px;
            overflow: hidden;
        }

        /* Tampilan desktop */
        @media (min-width: 769px) {
            .auth-container > * {
                min-height: 600px;
            }
        }

        /* Tampilan tablet dan HP */
        @media (max-width: 768px) {
            .auth-container {
                padding: 20px 15px;
                align-items: flex-start;
            }

            .auth-container > * {
                max-width: 480px;
                min-height: auto;
                border-radius: 18px;
            }
        }
    </style>
</head>

<body class="antialiased">

    <main class="auth-container">
        {{ $slot }}
    </main>

</body>
</html>
