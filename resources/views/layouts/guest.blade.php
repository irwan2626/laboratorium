<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#0f4c81">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="default">

        <title>{{ config('app.name', 'Pendataan Laboratorium') }}</title>

        <link rel="manifest" href="{{ asset('manifest.webmanifest') }}">
        <link rel="apple-touch-icon" href="{{ asset('icons/icon-192.svg') }}">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --background: #f5f7fb;
                --surface-container-lowest: #ffffff;
                --surface-container-low: #f7f9fc;
                --surface-container: #eef3f8;
                --surface-container-highest: #dce7ee;
                --on-surface: #12202f;
                --on-surface-variant: #506070;
                --outline-variant: #d7dee7;
                --primary: #0f4c81;
                --on-primary: #ffffff;
                --secondary: #25736f;
                --accent: #c97724;
                --error: #ba1a1a;
                --shadow: 0 18px 48px rgba(18, 32, 47, 0.16);
                --radius: 0.5rem;
            }

            * {
                box-sizing: border-box;
            }

            body {
                margin: 0;
                background: var(--background);
                color: var(--on-surface);
                font-family: Inter, Arial, sans-serif;
                -ms-overflow-style: none;
                scrollbar-width: none;
            }

            body::-webkit-scrollbar,
            .login-page::-webkit-scrollbar {
                width: 0;
                height: 0;
            }

            .login-page {
                min-height: 100vh;
                display: grid;
                place-items: center;
                padding: 40px 18px;
                overflow-y: auto;
                -ms-overflow-style: none;
                scrollbar-width: none;
                background:
                    linear-gradient(135deg, rgba(245, 247, 251, 0.9), rgba(238, 246, 244, 0.74)),
                    url("{{ asset('images/login-bg.jpg') }}");
                background-size: cover;
                background-position: center;
            }

            .login-card {
                position: relative;
                width: 100%;
                max-width: 460px;
                overflow: hidden;
                border: 1px solid rgba(255, 255, 255, 0.72);
                border-radius: var(--radius);
                padding: 34px;
                background: rgba(255, 255, 255, 0.9);
                box-shadow: var(--shadow);
                backdrop-filter: blur(12px);
            }

            .login-card::before {
                content: "";
                position: absolute;
                inset: 0 0 auto;
                height: 6px;
                background: linear-gradient(90deg, var(--primary), var(--secondary), var(--accent));
            }

            .login-card > * {
                position: relative;
            }

            .login-brand {
                display: grid;
                grid-template-columns: auto 1fr;
                gap: 14px;
                align-items: center;
                margin-bottom: 28px;
                padding-bottom: 22px;
                border-bottom: 1px solid var(--outline-variant);
                text-align: left;
            }

            .brand-mark {
                width: 54px;
                height: 54px;
                display: grid;
                place-items: center;
                border-radius: var(--radius);
                background: linear-gradient(135deg, var(--primary), var(--secondary));
                color: var(--on-primary);
                font-weight: 700;
                box-shadow: inset 0 -4px 0 rgba(255, 255, 255, 0.18);
            }

            .login-brand h1 {
                margin: 0;
                color: var(--primary);
                font-size: 23px;
                font-weight: 600;
                line-height: 30px;
                letter-spacing: 0;
            }

            .login-brand p {
                margin: 8px 0 0;
                color: var(--on-surface-variant);
                font-size: 14px;
                line-height: 20px;
            }

            .login-card label {
                color: var(--primary);
                font-size: 14px;
                font-weight: 600;
                line-height: 20px;
            }

            .login-card input[type="email"],
            .login-card input[type="password"] {
                min-height: 46px;
                border-color: transparent;
                border-radius: var(--radius);
                background: var(--surface-container-low);
                color: var(--on-surface);
                font-size: 14px;
                line-height: 20px;
                box-shadow: inset 0 0 0 1px var(--outline-variant);
            }

            .login-card input[type="email"]:focus,
            .login-card input[type="password"]:focus {
                border-color: var(--primary);
                background: var(--surface-container-lowest);
                box-shadow: 0 0 0 3px rgba(15, 76, 129, 0.14);
            }

            .login-card input[type="checkbox"] {
                border-radius: 4px;
                color: var(--primary);
            }

            .login-card span,
            .login-card p {
                color: var(--on-surface-variant);
            }

            .login-actions {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
                margin-top: 22px;
            }

            .login-link {
                color: var(--secondary);
                font-size: 14px;
                line-height: 20px;
                text-decoration: none;
            }

            .login-link:hover {
                color: var(--primary);
                text-decoration: underline;
            }

            .login-button {
                min-height: 44px;
                border: 1px solid var(--primary);
                border-radius: var(--radius);
                padding: 10px 20px;
                background: linear-gradient(135deg, var(--primary), #176099);
                color: var(--on-primary);
                font-size: 14px;
                font-weight: 600;
                line-height: 20px;
                cursor: pointer;
                box-shadow: 0 10px 22px rgba(15, 76, 129, 0.22);
            }

            .login-button:hover {
                background: linear-gradient(135deg, #0b3f6c, var(--primary));
            }

            @media (max-width: 520px) {
                .login-page {
                    align-items: start;
                    padding: 20px 12px 16px;
                }

                .login-card {
                    width: 100%;
                    max-width: 100%;
                    padding: 22px 16px 18px;
                    border-radius: 0.75rem;
                }

                .login-brand {
                    grid-template-columns: 1fr;
                    gap: 10px;
                    margin-bottom: 22px;
                    padding-bottom: 18px;
                    text-align: center;
                }

                .brand-mark {
                    width: 48px;
                    height: 48px;
                    margin: 0 auto;
                }

                .login-brand h1 {
                    font-size: 18px;
                    line-height: 24px;
                }

                .login-brand p {
                    font-size: 13px;
                    line-height: 18px;
                }

                .login-actions {
                    align-items: stretch;
                    flex-direction: column;
                    gap: 10px;
                    margin-top: 18px;
                }

                .login-link,
                .login-button {
                    width: 100%;
                }

                .login-card input[type="email"],
                .login-card input[type="password"] {
                    min-height: 44px;
                    font-size: 16px;
                }
            }
        </style>
    </head>
    <body>
        <main class="login-page">
            <section class="login-card">
                <div class="login-brand">
                    <div class="brand-mark">PL</div>
                    <h1>Pendataan Laboratorium</h1>
                    <p>Masuk untuk mengelola data kerusakan alat.</p>
                </div>

                {{ $slot }}
            </section>
        </main>

        <script>
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', function () {
                    navigator.serviceWorker.register('/sw.js');
                });
            }
        </script>
    </body>
</html>
