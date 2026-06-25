<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Asisten Laboratorium')</title>
    <style>
        :root {
            --background: #f9f9ff;
            --surface: #f9f9ff;
            --surface-container-lowest: #ffffff;
            --surface-container-low: #f0f3ff;
            --surface-container: #e7eeff;
            --surface-container-high: #dee8ff;
            --surface-variant: #d8e3fb;
            --on-surface: #111c2d;
            --on-surface-variant: #42474f;
            --inverse-surface: #263143;
            --inverse-on-surface: #ecf1ff;
            --outline: #727780;
            --outline-variant: #c2c7d1;
            --primary: #00355f;
            --on-primary: #ffffff;
            --primary-container: #0f4c81;
            --on-primary-container: #8ebdf9;
            --secondary: #505f76;
            --on-secondary: #ffffff;
            --secondary-container: #d0e1fb;
            --tertiary: #313436;
            --error: #ba1a1a;
            --error-container: #ffdad6;
            --healthy: #16894a;
            --healthy-container: #dff6e9;
            --warning: #ad7b00;
            --warning-container: #fff1c2;
            --shadow: 0 4px 6px -1px rgba(17, 28, 45, 0.05), 0 2px 4px -2px rgba(17, 28, 45, 0.08);
            --radius-sm: 0.25rem;
            --radius: 0.5rem;
            --radius-md: 0.75rem;
            --sidebar-width: 260px;
            --gutter: 24px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Inter, Arial, sans-serif;
            background: var(--background);
            color: var(--on-surface);
            overflow-x: hidden;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        body::-webkit-scrollbar,
        .content::-webkit-scrollbar,
        .sidebar::-webkit-scrollbar {
            width: 0;
            height: 0;
        }

        .app-shell {
            min-height: 100vh;
            display: grid;
            grid-template-columns: var(--sidebar-width) minmax(0, 1fr);
        }

        .sidebar {
            background: var(--surface-container-lowest);
            border-right: 1px solid var(--outline-variant);
            box-shadow: var(--shadow);
            color: var(--on-surface);
            padding: 24px 18px;
            display: flex;
            flex-direction: column;
            gap: 24px;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .nav-toggle {
            display: none;
        }

        .brand-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }

        .logout-top-right {
            display: none;
            flex: 0 0 auto;
            margin-left: auto;
            border: 1px solid var(--outline-variant);
            border-radius: var(--radius);
            padding: 10px 12px;
            background: var(--surface-container-lowest);
            color: var(--error);
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .logout-top-right:hover {
            background: var(--error-container);
            color: var(--error);
        }

        .logout-top-right .logout-button {
            width: auto;
            padding: 0;
            border: 0;
            background: transparent;
            color: inherit;
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

        .nav-item-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
            flex: 0 0 auto;
        }

        .nav-item-icon svg {
            width: 20px;
            height: 20px;
            stroke: currentColor;
            fill: none;
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .menu-label {
            display: inline-block;
        }

        .brand {
            border-bottom: 1px solid var(--outline-variant);
            padding-bottom: 18px;
        }

        .brand h1 {
            margin: 0;
            color: var(--primary);
            font-size: 20px;
            font-weight: 700;
            line-height: 28px;
            letter-spacing: 0;
        }

        .brand p {
            margin: 6px 0 0;
            color: var(--on-surface-variant);
            font-size: 14px;
            line-height: 20px;
        }

        .account-box {
            margin-top: 14px;
            border: 1px solid var(--outline-variant);
            border-radius: var(--radius);
            padding: 12px;
            background: var(--surface-container-low);
        }

        .account-box span {
            display: block;
            color: var(--secondary);
            font-size: 12px;
            font-weight: 600;
            line-height: 16px;
            letter-spacing: 0.05em;
            margin-bottom: 4px;
            text-transform: uppercase;
        }

        .account-box strong {
            display: block;
            font-size: 15px;
            line-height: 20px;
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
            text-decoration: none;
            text-align: left;
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
            width: 100%;
            max-width: 1440px;
            min-width: 0;
            margin: 0 auto;
            padding: 32px var(--gutter);
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .topbar {
            background: var(--surface-container-lowest);
            border: 1px solid var(--outline-variant);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 20px 24px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
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

        .topbar span,
        .eyebrow {
            color: var(--secondary);
            font-size: 14px;
            line-height: 20px;
        }

        .eyebrow {
            display: block;
            margin-bottom: 4px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .panel {
            background: var(--surface-container-lowest);
            border: 1px solid var(--outline-variant);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 24px;
            margin-bottom: 24px;
        }

        .panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 16px;
        }

        .panel h3 {
            margin: 0;
            color: var(--on-surface);
            font-size: 20px;
            font-weight: 600;
            line-height: 28px;
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
            background: var(--surface-container-lowest);
            border: 1px solid var(--outline-variant);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
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
            letter-spacing: 0;
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

        .stat-dot {
            width: 8px;
            height: 8px;
            border-radius: 9999px;
            background: var(--primary);
        }

        .status-light .stat-dot {
            background: var(--healthy);
        }

        .status-medium .stat-dot {
            background: var(--warning);
        }

        .status-heavy .stat-dot,
        .status-critical .stat-dot {
            background: var(--error);
        }

        .action-row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 18px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--primary);
            border-radius: var(--radius);
            padding: 10px 14px;
            background: var(--primary);
            color: var(--on-primary);
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
            line-height: 20px;
            font-weight: 600;
        }

        .btn-gold {
            border-color: var(--secondary);
            background: var(--secondary);
        }

        .btn-outline {
            background: var(--surface-container-lowest);
            color: var(--secondary);
            border-color: var(--outline-variant);
        }

        .btn-danger {
            background: var(--error);
            border-color: var(--error);
            color: var(--on-error);
        }

        .table-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .table-actions .btn {
            min-height: 34px;
            padding: 6px 10px;
            font-size: 12px;
            line-height: 16px;
        }

        .inline-form {
            display: inline;
            margin: 0;
        }

        .form-stack {
            max-width: 720px;
        }

        .form-actions {
            margin-bottom: 0;
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

        label {
            display: block;
            margin-bottom: 6px;
            font-size: 14px;
            font-weight: 600;
            line-height: 20px;
            color: var(--primary);
        }

        input,
        select,
        textarea {
            min-height: 42px;
            width: 100%;
            border: 1px solid var(--outline-variant);
            border-radius: var(--radius);
            padding: 10px 12px;
            font-size: 14px;
            line-height: 20px;
            color: var(--on-surface);
            background: var(--surface-container-lowest);
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: var(--primary);
            outline: 3px solid rgba(15, 76, 129, 0.14);
        }

        textarea {
            min-height: 110px;
            resize: vertical;
        }

        .mb-3 {
            margin-bottom: 16px;
        }

        .success-message {
            background: var(--healthy-container);
            border-left: 5px solid var(--healthy);
            border-radius: var(--radius);
            padding: 12px 14px;
            color: var(--healthy);
            margin-bottom: 16px;
        }

        .qr-reader {
            max-width: 620px;
            margin: 0 auto;
            border: 2px solid var(--outline-variant);
            border-radius: var(--radius);
            overflow: hidden;
            background: var(--surface-container-lowest);
        }

        img.preview {
            width: 92px;
            height: 70px;
            object-fit: cover;
            border-radius: var(--radius);
            border: 1px solid var(--outline-variant);
        }

        .muted {
            color: var(--on-surface-variant);
        }

        @media (max-width: 1100px) {
            :root {
                --gutter: 20px;
                --sidebar-width: 232px;
            }

            .sidebar {
                padding: 20px 14px;
            }

            .stat-card {
                grid-column: span 6;
            }
        }

        @media (max-width: 820px) {
            :root {
                --gutter: 16px;
            }

            .app-shell {
                grid-template-columns: 1fr;
            }

            .sidebar {
                position: static;
                border-right: 0;
                border-bottom: 0;
                padding: 16px;
                gap: 14px;
            }

            .brand {
                display: grid;
                grid-template-columns: minmax(0, 1fr);
                gap: 12px;
                padding-bottom: 14px;
            }

            .brand-header {
                align-items: center;
            }

            .brand h1 {
                font-size: 20px;
                line-height: 28px;
            }

            .account-box {
                margin-top: 8px;
            }

            .mobile-menu-button {
                display: none;
            }

            .logout-top-right {
                display: inline-flex;
            }

            .logout-top-right .logout-button {
                min-height: 0;
            }

            .mobile-menu-panel {
                position: fixed;
                left: 12px;
                right: 12px;
                bottom: 12px;
                z-index: 50;
                display: grid;
                gap: 10px;
                padding: 12px;
                border: 1px solid var(--outline-variant);
                border-radius: 18px;
                background: rgba(255, 255, 255, 0.98);
                box-shadow: 0 14px 30px rgba(17, 28, 45, 0.14);
                backdrop-filter: blur(12px);
            }

            .nav-toggle:checked + .sidebar .mobile-menu-panel {
                display: grid;
            }

            .menu {
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 8px;
                overflow-x: visible;
                padding-bottom: 0;
            }

            .menu a,
            .logout-button {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                min-height: 72px;
                padding: 10px 8px;
                text-align: center;
                white-space: normal;
                flex-direction: column;
            }

            .menu a.active::before {
                top: auto;
                right: 12px;
                bottom: 8px;
                left: 12px;
                width: auto;
                height: 3px;
                border-radius: 9999px;
            }

            .menu-label {
                font-size: 12px;
                line-height: 16px;
            }

            .logout-form {
                display: none;
            }

            .content {
                padding: 16px 16px 112px;
            }

            .topbar {
                align-items: flex-start;
                flex-direction: column;
                padding: 18px;
            }

            .topbar h2 {
                font-size: 20px;
                line-height: 28px;
            }

            .panel {
                padding: 18px;
            }

            .panel-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .stat-card {
                grid-column: auto;
            }

            .action-row,
            .table-actions {
                align-items: stretch;
                flex-direction: column;
            }

            .btn,
            .table-actions .btn,
            .inline-form,
            .inline-form .btn {
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
            .stat-card {
                border-radius: var(--radius);
            }

            .menu {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                overflow-x: visible;
            }

            .menu a,
            .logout-button {
                width: 100%;
                white-space: normal;
            }

            .mobile-menu-panel {
                left: 10px;
                right: 10px;
                bottom: 10px;
                padding: 10px;
            }

            .menu a,
            .logout-button {
                min-height: 70px;
                padding: 8px 6px;
            }

            .menu-label {
                font-size: 11px;
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
    <div class="app-shell">
        <input class="nav-toggle" type="checkbox" id="asisten-menu-toggle">
        <aside class="sidebar">
            <div class="brand">
                <div class="brand-header">
                    <h1>Asisten Laboratorium</h1>
                    <label class="mobile-menu-button" for="asisten-menu-toggle" aria-label="Buka menu">
                        <span></span>
                    </label>
                    <form class="logout-top-right" method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="logout-button" type="submit">
                            <span class="nav-item-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24">
                                    <path d="M10 17l5-5-5-5"></path>
                                    <path d="M15 12H4"></path>
                                    <path d="M20 4v16"></path>
                                </svg>
                            </span>
                            <span class="menu-label">Logout</span>
                        </button>
                    </form>
                </div>
                <p>Panel pendataan kerusakan alat</p>
                <div class="account-box">
                    <span>Akun</span>
                    <strong>{{ auth()->user()->name ?? 'Asisten' }}</strong>
                </div>
            </div>

            <div class="mobile-menu-panel">
                <nav class="menu">
                    <a href="/asisten/dashboard" class="{{ request()->is('asisten/dashboard') ? 'active' : '' }}">
                        <span class="nav-item-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24">
                                <path d="M4 10.5 12 4l8 6.5"></path>
                                <path d="M6.5 9.5V20h11V9.5"></path>
                                <path d="M10 20v-6h4v6"></path>
                            </svg>
                        </span>
                        <span class="menu-label">Dashboard</span>
                    </a>
                    <a href="/scan" class="{{ request()->is('scan') ? 'active' : '' }}">
                        <span class="nav-item-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24">
                                <path d="M7 3H5a2 2 0 0 0-2 2v2"></path>
                                <path d="M17 3h2a2 2 0 0 1 2 2v2"></path>
                                <path d="M7 21H5a2 2 0 0 1-2-2v-2"></path>
                                <path d="M17 21h2a2 2 0 0 0 2-2v-2"></path>
                                <path d="M9 9h6v6H9z"></path>
                            </svg>
                        </span>
                        <span class="menu-label">Scan QR</span>
                    </a>
                    <a href="/data-kerusakan" class="{{ request()->is('data-kerusakan') ? 'active' : '' }}">
                        <span class="nav-item-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24">
                                <path d="M5 5h14v14H5z"></path>
                                <path d="M8 9h8"></path>
                                <path d="M8 13h8"></path>
                                <path d="M8 17h5"></path>
                            </svg>
                        </span>
                        <span class="menu-label">Data Kerusakan</span>
                    </a>
                </nav>

            </div>
        </aside>

        <main class="content">

            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
