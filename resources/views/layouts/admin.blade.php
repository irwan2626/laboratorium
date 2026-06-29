<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#00355f">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <title>@yield('title', 'Dashboard Admin')</title>
    <link rel="manifest" href="{{ asset('manifest.webmanifest') }}">
    <link rel="apple-touch-icon" href="{{ asset('icons/icon-192.png') }}">
    <style>
        :root {
            --background: #f9f9ff;
            --surface-container-lowest: #ffffff;
            --surface-container-low: #f0f3ff;
            --surface-container: #e7eeff;
            --surface-container-high: #dee8ff;
            --on-surface: #111c2d;
            --on-surface-variant: #42474f;
            --outline: #727780;
            --outline-variant: #c2c7d1;
            --primary: #00355f;
            --on-primary: #ffffff;
            --secondary: #505f76;
            --secondary-container: #d0e1fb;
            --error: #ba1a1a;
            --on-error: #ffffff;
            --error-container: #ffdad6;
            --healthy: #16894a;
            --healthy-container: #dff6e9;
            --warning: #ad7b00;
            --warning-container: #fff1c2;
            --shadow: 0 4px 6px -1px rgba(17, 28, 45, 0.05), 0 2px 4px -2px rgba(17, 28, 45, 0.08);
            --radius-sm: 0.25rem;
            --radius: 0.5rem;
            --sidebar-width: 260px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            overflow: hidden;
            background: var(--background);
            color: var(--on-surface);
            font-family: Inter, Arial, sans-serif;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        body::-webkit-scrollbar,
        .content::-webkit-scrollbar,
        .sidebar::-webkit-scrollbar {
            width: 0;
            height: 0;
        }

        .admin-shell {
            min-height: 100vh;
            height: 100vh;
            display: grid;
            grid-template-columns: var(--sidebar-width) minmax(0, 1fr);
        }

        .sidebar {
            height: 100vh;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 24px;
            padding: 24px 18px;
            border-right: 1px solid var(--outline-variant);
            background: var(--surface-container-lowest);
            box-shadow: var(--shadow);
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .nav-toggle {
            display: none;
        }

        .brand {
            border-bottom: 1px solid var(--outline-variant);
            padding-bottom: 18px;
        }

        .brand-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }

        .brand h1 {
            margin: 0;
            color: var(--primary);
            font-size: 20px;
            font-weight: 700;
            line-height: 28px;
        }

        .brand p {
            margin: 8px 0 0;
            color: var(--on-surface-variant);
            font-size: 14px;
            line-height: 20px;
        }

        .mobile-menu-button {
            display: none;
            width: 42px;
            height: 42px;
            flex: 0 0 auto;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--outline-variant);
            border-radius: var(--radius);
            background: var(--surface-container-lowest);
            color: var(--primary);
            cursor: pointer;
        }

        .mobile-menu-button span,
        .mobile-menu-button span::before,
        .mobile-menu-button span::after {
            display: block;
            width: 18px;
            height: 2px;
            border-radius: 9999px;
            background: currentColor;
            content: "";
        }

        .mobile-menu-button span {
            position: relative;
        }

        .mobile-menu-button span::before,
        .mobile-menu-button span::after {
            position: absolute;
            left: 0;
        }

        .mobile-menu-button span::before {
            top: -6px;
        }

        .mobile-menu-button span::after {
            top: 6px;
        }

        .mobile-menu-panel {
            display: flex;
            flex: 1;
            flex-direction: column;
            gap: 24px;
        }

        .menu {
            display: grid;
            gap: 8px;
        }

        .menu a,
        .logout-button {
            position: relative;
            display: block;
            width: 100%;
            border: 1px solid transparent;
            border-radius: var(--radius);
            padding: 12px 14px 12px 18px;
            background: transparent;
            color: var(--on-surface-variant);
            text-align: left;
            text-decoration: none;
            font-size: 14px;
            line-height: 20px;
            cursor: pointer;
        }

        .menu a:hover,
        .logout-button:hover {
            background: var(--surface-container-low);
            color: var(--primary);
        }

        .menu a.active {
            background: var(--secondary-container);
            color: var(--primary);
            font-weight: 600;
        }

        .menu a.active::before {
            position: absolute;
            top: 10px;
            bottom: 10px;
            left: 0;
            width: 4px;
            border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
            background: var(--primary);
            content: "";
        }

        .logout-form {
            margin-top: auto;
        }

        .content {
            min-width: 0;
            height: 100vh;
            max-width: 1440px;
            margin: 0 auto;
            padding: 32px 24px;
            overflow-y: auto;
            overflow-x: hidden;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .topbar,
        .panel,
        .stat-card {
            border: 1px solid var(--outline-variant);
            border-radius: var(--radius);
            background: var(--surface-container-lowest);
            box-shadow: var(--shadow);
        }

        .topbar {
            margin-bottom: 24px;
        }

        .topbar h2 {
            margin: 0;
            color: var(--primary);
            font-size: 24px;
            font-weight: 600;
            line-height: 32px;
            letter-spacing: 0;
        }

        .topbar p {
            margin: 4px 0 0;
            color: var(--on-surface-variant);
            font-size: 14px;
            line-height: 20px;
        }

        .eyebrow {
            display: block;
            margin-bottom: 4px;
            color: var(--secondary);
            font-size: 12px;
            font-weight: 600;
            line-height: 16px;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(12, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            position: relative;
            grid-column: span 3;
            overflow: hidden;
            padding: 20px 20px 18px 24px;
        }

        .stat-card::before {
            position: absolute;
            inset: 0 auto 0 0;
            width: 5px;
            background: var(--primary);
            content: "";
        }

        .stat-card.status-light::before {
            background: var(--healthy);
        }

        .stat-card.status-medium::before {
            background: var(--warning);
        }

        .stat-card.status-heavy::before,
        .stat-card.status-critical::before {
            background: var(--error);
        }

        .stat-card p {
            margin: 0 0 8px;
            color: var(--secondary);
            font-size: 12px;
            font-weight: 600;
            line-height: 16px;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .stat-card strong {
            display: block;
            color: var(--primary);
            font-size: 24px;
            font-weight: 600;
            line-height: 32px;
        }

        .stat-meta {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 10px;
            color: var(--on-surface-variant);
            font-size: 12px;
            line-height: 16px;
        }

        .panel {
            margin-bottom: 24px;
            padding: 24px;
        }

        .panel h3 {
            margin: 0 0 18px;
            color: var(--on-surface);
            font-size: 20px;
            font-weight: 600;
            line-height: 28px;
        }

        .lab-panel-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 18px;
        }

        .lab-panel-header h3 {
            margin-bottom: 0;
        }

        .lab-table {
            max-height: 520px;
            overflow: auto;
        }

        .table-preview {
            width: 88px;
            height: 64px;
            object-fit: cover;
            border: 1px solid var(--outline-variant);
            border-radius: var(--radius);
        }

        .chart-row {
            display: grid;
            grid-template-columns: 180px 1fr 48px;
            gap: 12px;
            align-items: center;
            margin-bottom: 14px;
        }

        .chart-row strong {
            font-size: 14px;
            line-height: 20px;
        }

        .bar-track {
            height: 16px;
            overflow: hidden;
            border-radius: 1rem;
            background: var(--surface-container);
        }

        .bar-fill {
            height: 100%;
            min-width: 8px;
            border-radius: 1rem;
            background: var(--primary);
        }

        .action-row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 18px;
        }

        .tab-button,
        .btn,
        .danger-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: var(--radius);
            padding: 10px 14px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            line-height: 20px;
            cursor: pointer;
        }

        .tab-button {
            border: 1px solid var(--outline-variant);
            background: var(--surface-container-lowest);
            color: var(--secondary);
        }

        .tab-button.active,
        .tab-button:hover {
            border-color: var(--primary);
            background: var(--primary);
            color: var(--on-primary);
        }

        .tab-button.active {
        }

        .btn {
            border: 1px solid var(--primary);
            background: var(--primary);
            color: var(--on-primary);
        }

        .btn-gold {
            border-color: var(--secondary);
            background: var(--secondary);
        }

        .btn-outline {
            border-color: var(--outline-variant);
            background: var(--surface-container-lowest);
            color: var(--secondary);
        }

        .danger-button {
            border: 1px solid var(--error);
            background: var(--error);
            color: var(--on-error);
        }

        .tab-panel,
        .kategori-panel {
            display: none;
        }

        .tab-panel.active,
        .kategori-panel.active {
            display: block;
        }

        .inline-form {
            display: inline;
        }

        .alert {
            margin-bottom: 18px;
            border-radius: var(--radius);
            padding: 12px 14px;
            font-size: 14px;
            line-height: 20px;
        }

        .success-alert {
            border: 1px solid var(--healthy);
            background: var(--healthy-container);
            color: var(--healthy);
        }

        label {
            display: block;
            margin-bottom: 6px;
            color: var(--primary);
            font-size: 14px;
            font-weight: 600;
            line-height: 20px;
        }

        input,
        select {
            min-height: 42px;
            width: 100%;
            border: 1px solid var(--outline-variant);
            border-radius: var(--radius);
            padding: 10px 12px;
            background: var(--surface-container-lowest);
            color: var(--on-surface);
            font-size: 14px;
            line-height: 20px;
        }

        input:focus,
        select:focus {
            border-color: var(--primary);
            outline: 3px solid rgba(15, 76, 129, 0.14);
        }

        .form-grid {
            display: grid;
            gap: 16px;
            max-width: 620px;
        }

        .table-wrap {
            width: 100%;
            overflow-x: auto;
            border: 1px solid var(--outline-variant);
            border-radius: var(--radius);
            -webkit-overflow-scrolling: touch;
        }

        table {
            width: 100%;
            min-width: 760px;
            border-collapse: collapse;
            background: var(--surface-container-lowest);
        }

        th {
            background: var(--surface-container);
            color: var(--secondary);
            text-align: left;
            padding: 12px 14px;
            font-size: 12px;
            font-weight: 600;
            line-height: 16px;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            white-space: nowrap;
        }

        td {
            border-bottom: 1px solid var(--outline-variant);
            padding: 12px 14px;
            vertical-align: top;
            font-size: 14px;
            line-height: 20px;
            overflow-wrap: anywhere;
        }

        tr:nth-child(even) td {
            background: var(--surface-container-low);
        }

        tr:last-child td {
            border-bottom: 0;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            min-height: 24px;
            border-radius: 9999px;
            padding: 2px 10px;
            background: var(--surface-container-high);
            color: var(--secondary);
            font-size: 12px;
            font-weight: 600;
            line-height: 16px;
        }

        .status-pill.light {
            background: var(--healthy-container);
            color: var(--healthy);
        }

        .status-pill.medium {
            background: var(--warning-container);
            color: var(--warning);
        }

        .status-pill.heavy,
        .status-pill.critical {
            background: var(--error-container);
            color: var(--error);
        }

        @media (max-width: 1100px) {
            .admin-shell {
                grid-template-columns: 232px minmax(0, 1fr);
            }

            .sidebar {
                padding: 20px 14px;
            }

            .content {
                padding: 22px;
            }

            .stat-card {
                grid-column: span 6;
            }
        }

        @media (max-width: 820px) {
            body {
                overflow: auto;
            }

            .admin-shell {
                height: auto;
                min-height: 100vh;
                grid-template-columns: 1fr;
            }

            .sidebar {
                position: relative;
                height: auto;
                overflow-y: visible;
                padding: 16px;
                gap: 14px;
                border-right: 0;
                border-bottom: 1px solid var(--outline-variant);
            }

            .brand {
                padding-bottom: 14px;
            }

            .brand h1,
            .topbar h2 {
                font-size: 20px;
                line-height: 28px;
            }

            .mobile-menu-button {
                display: inline-flex;
            }

            .mobile-menu-panel {
                position: fixed;
                top: 0;
                left: 0;
                z-index: 1000;
                display: flex;
                flex-direction: column;
                gap: 12px;
                width: min(82vw, 320px);
                height: 100vh;
                padding: 22px 16px 16px;
                border-right: 1px solid var(--outline-variant);
                background: var(--surface-container-lowest);
                box-shadow: 18px 0 32px rgba(17, 28, 45, 0.14);
                transform: translateX(-100%);
                transition: transform 0.22s ease;
                overflow-y: auto;
                pointer-events: none;
            }

            .nav-toggle:checked + .sidebar .mobile-menu-panel {
                transform: translateX(0);
                pointer-events: auto;
            }

            .menu {
                gap: 8px;
            }

            .logout-form {
                margin-top: 0;
            }

            .content {
                height: auto;
                padding: 16px;
                overflow-y: visible;
            }

            .topbar,
            .panel,
            .stat-card {
                padding: 18px;
            }

            .stats-grid,
            .chart-row {
                grid-template-columns: 1fr;
            }

            .stat-card {
                grid-column: auto;
            }

            .action-row {
                align-items: stretch;
                flex-direction: column;
            }

            .btn,
            .tab-button,
            .danger-button,
            .inline-form,
            .inline-form button {
                width: 100%;
            }
        }

        @media (max-width: 520px) {
            .sidebar,
            .content {
                padding-left: 12px;
                padding-right: 12px;
            }

            .mobile-menu-panel {
                width: min(86vw, 300px);
                padding: 20px 14px 14px;
            }

            table {
                min-width: 680px;
            }

            th,
            td {
                padding: 10px 12px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="admin-shell">
        <input class="nav-toggle" type="checkbox" id="admin-menu-toggle">
        <aside class="sidebar">
            <div class="brand">
                <div class="brand-header">
                    <h1>Dashboard Admin</h1>
                    <label class="mobile-menu-button" for="admin-menu-toggle" aria-label="Buka menu">
                        <span></span>
                    </label>
                </div>
                <p>{{ auth()->user()->name ?? 'Admin' }}</p>
            </div>

            <div class="mobile-menu-panel">
                <nav class="menu">
                    <a href="/admin/dashboard" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">Dashboard Utama</a>
                    <a href="{{ route('admin.laboratorium.index') }}" class="{{ request()->is('admin/laboratorium') ? 'active' : '' }}">Kelola Data Laboratorium</a>
                    <a href="{{ route('users.index') }}" class="{{ request()->is('users*') ? 'active' : '' }}">Kelola Data User</a>
                </nav>

                <form class="logout-form" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="logout-button" type="submit">Logout</button>
                </form>
            </div>
        </aside>

        <main class="content">
            @yield('content')
        </main>
    </div>
    @stack('scripts')
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function () {
                navigator.serviceWorker.register('/sw.js');
            });
        }
    </script>
</body>
</html>
