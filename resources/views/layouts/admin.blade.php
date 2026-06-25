<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin')</title>
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
            padding: 28px 24px 32px;
            overflow-y: auto;
            overflow-x: hidden;
            -ms-overflow-style: none;
            scrollbar-width: none;
            background:
                radial-gradient(circle at top right, rgba(15, 76, 129, 0.08), transparent 28%),
                radial-gradient(circle at bottom left, rgba(37, 115, 111, 0.08), transparent 24%),
                linear-gradient(180deg, rgba(249, 249, 255, 0.82), rgba(249, 249, 255, 1));
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
            padding: 22px 24px;
            position: relative;
            overflow: hidden;
        }

        .topbar::after {
            content: "";
            position: absolute;
            inset: 0 0 auto auto;
            width: 220px;
            height: 220px;
            transform: translate(35%, -45%);
            border-radius: 9999px;
            background: radial-gradient(circle, rgba(15, 76, 129, 0.15), transparent 68%);
            pointer-events: none;
        }

        .dashboard-hero {
            display: grid;
            grid-template-columns: minmax(0, 1.5fr) minmax(320px, 0.9fr);
            gap: 18px;
            align-items: stretch;
            margin-bottom: 24px;
        }

        .hero-card {
            position: relative;
            overflow: hidden;
            border: 1px solid var(--outline-variant);
            border-radius: var(--radius);
            background: linear-gradient(135deg, #0f4c81 0%, #16608f 55%, #25736f 100%);
            color: var(--on-primary);
            box-shadow: var(--shadow);
            padding: 26px;
        }

        .hero-card::before,
        .hero-card::after {
            content: "";
            position: absolute;
            border-radius: 9999px;
            pointer-events: none;
        }

        .hero-card::before {
            top: -60px;
            right: -20px;
            width: 160px;
            height: 160px;
            background: rgba(255, 255, 255, 0.12);
        }

        .hero-card::after {
            bottom: -70px;
            right: 110px;
            width: 180px;
            height: 180px;
            background: rgba(255, 255, 255, 0.08);
        }

        .hero-card > * {
            position: relative;
            z-index: 1;
        }

        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
            padding: 7px 12px;
            border-radius: 9999px;
            background: rgba(255, 255, 255, 0.14);
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .hero-title {
            margin: 0;
            font-size: 30px;
            font-weight: 700;
            line-height: 38px;
            letter-spacing: 0;
        }

        .hero-text {
            max-width: 640px;
            margin: 10px 0 0;
            color: rgba(255, 255, 255, 0.9);
            font-size: 15px;
            line-height: 22px;
        }

        .hero-metrics {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
            margin-top: 22px;
        }

        .hero-metric {
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: var(--radius);
            padding: 14px 14px 12px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .hero-metric span {
            display: block;
            color: rgba(255, 255, 255, 0.78);
            font-size: 12px;
            font-weight: 600;
            line-height: 16px;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .hero-metric strong {
            display: block;
            margin-top: 8px;
            font-size: 28px;
            font-weight: 700;
            line-height: 32px;
        }

        .hero-side {
            display: grid;
            gap: 18px;
        }

        .quick-actions {
            display: grid;
            gap: 14px;
        }

        .quick-actions h3 {
            margin: 0;
            color: var(--primary);
            font-size: 18px;
            font-weight: 600;
            line-height: 26px;
        }

        .quick-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .quick-card {
            display: flex;
            flex-direction: column;
            gap: 10px;
            min-height: 100px;
            padding: 16px;
            border: 1px solid var(--outline-variant);
            border-radius: var(--radius);
            background: var(--surface-container-lowest);
            box-shadow: var(--shadow);
            text-decoration: none;
            color: var(--on-surface);
        }

        .quick-card strong {
            color: var(--primary);
            font-size: 15px;
            line-height: 22px;
        }

        .quick-card span {
            color: var(--on-surface-variant);
            font-size: 13px;
            line-height: 18px;
        }

        .quick-card:hover {
            border-color: rgba(15, 76, 129, 0.22);
            transform: translateY(-1px);
        }

        .quick-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 9999px;
            background: var(--surface-container-low);
            color: var(--primary);
        }

        .quick-icon svg {
            width: 20px;
            height: 20px;
            stroke: currentColor;
            fill: none;
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
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
            transition: transform 0.18s ease, box-shadow 0.18s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 22px rgba(17, 28, 45, 0.08);
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
            background: linear-gradient(90deg, var(--primary), #176099);
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
            box-shadow: 0 10px 18px rgba(15, 76, 129, 0.18);
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
            background: var(--surface-container-lowest);
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
                display: none;
                gap: 12px;
            }

            .nav-toggle:checked + .sidebar .mobile-menu-panel {
                display: grid;
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

            .dashboard-hero {
                grid-template-columns: 1fr;
                gap: 14px;
            }

            .hero-card {
                padding: 20px;
            }

            .hero-title {
                font-size: 24px;
                line-height: 32px;
            }

            .hero-text {
                font-size: 14px;
                line-height: 20px;
            }

            .hero-metrics {
                grid-template-columns: 1fr;
            }

            .quick-grid {
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

            .topbar,
            .panel,
            .hero-card,
            .quick-card,
            .stat-card {
                border-radius: 0.75rem;
            }

            .topbar {
                padding: 16px;
            }

            .panel {
                padding: 16px;
            }

            .hero-card {
                padding: 18px 16px;
            }

            .hero-title {
                font-size: 22px;
                line-height: 30px;
            }

            .hero-metric strong {
                font-size: 24px;
                line-height: 28px;
            }

            .quick-card {
                min-height: 92px;
                padding: 14px;
            }

            .quick-grid {
                gap: 10px;
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
</body>
</html>
