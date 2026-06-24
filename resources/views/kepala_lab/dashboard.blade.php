@php
    $bulan = [
        1 => 'Jan',
        2 => 'Feb',
        3 => 'Mar',
        4 => 'Apr',
        5 => 'Mei',
        6 => 'Jun',
        7 => 'Jul',
        8 => 'Agu',
        9 => 'Sep',
        10 => 'Okt',
        11 => 'Nov',
        12 => 'Des',
    ];

    $totalBulanan = $grafikBulanan->sum();
    $totalPerLabor = array_sum($grafikPerLabor);
    $chartColors = ['#00355f', '#0f4c81', '#505f76', '#16894a', '#ad7b00', '#ba1a1a', '#313436', '#727780', '#8ebdf9', '#54647a', '#c4c7c9', '#42474f'];

    $monthlySegments = [];
    $monthlyStart = 0;

    foreach ($bulan as $nomorBulan => $namaBulan) {
        $total = $grafikBulanan[$nomorBulan] ?? 0;
        $percent = $totalBulanan > 0 ? ($total / $totalBulanan) * 100 : 0;
        $monthlySegments[] = [
            'label' => $namaBulan,
            'total' => $total,
            'color' => $chartColors[($nomorBulan - 1) % count($chartColors)],
            'start' => $monthlyStart,
            'end' => $monthlyStart + $percent,
        ];
        $monthlyStart += $percent;
    }

    $laborSegments = [];
    $laborStart = 0;
    $laborIndex = 0;

    foreach ($grafikPerLabor as $laboratorium => $total) {
        $percent = $totalPerLabor > 0 ? ($total / $totalPerLabor) * 100 : 0;
        $laborSegments[] = [
            'label' => $laboratorium,
            'total' => $total,
            'color' => $chartColors[$laborIndex % count($chartColors)],
            'start' => $laborStart,
            'end' => $laborStart + $percent,
        ];
        $laborStart += $percent;
        $laborIndex++;
    }
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kepala Laboratorium</title>
    <style>
        :root {
            --background: #f9f9ff;
            --surface-container-lowest: #ffffff;
            --surface-container-low: #f0f3ff;
            --surface-container: #e7eeff;
            --surface-container-high: #dee8ff;
            --on-surface: #111c2d;
            --on-surface-variant: #42474f;
            --outline-variant: #c2c7d1;
            --primary: #00355f;
            --on-primary: #ffffff;
            --secondary: #505f76;
            --secondary-container: #d0e1fb;
            --error: #ba1a1a;
            --error-container: #ffdad6;
            --healthy: #16894a;
            --healthy-container: #dff6e9;
            --warning: #ad7b00;
            --warning-container: #fff1c2;
            --shadow: 0 4px 6px -1px rgba(17, 28, 45, 0.05), 0 2px 4px -2px rgba(17, 28, 45, 0.08);
            --radius-sm: 0.25rem;
            --radius: 0.5rem;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Inter, Arial, sans-serif;
            background: var(--background);
            color: var(--on-surface);
            overflow: hidden;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        body::-webkit-scrollbar,
        .content::-webkit-scrollbar,
        .sidebar::-webkit-scrollbar {
            width: 0;
            height: 0;
        }

        .shell {
            height: 100vh;
            display: grid;
            grid-template-columns: 260px minmax(0, 1fr);
        }

        .sidebar {
            background: var(--surface-container-lowest);
            border-right: 1px solid var(--outline-variant);
            box-shadow: var(--shadow);
            color: var(--on-surface);
            padding: 24px 18px;
            display: flex;
            flex-direction: column;
            gap: 18px;
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
            gap: 18px;
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
        }

        .brand p {
            margin: 8px 0 0;
            color: var(--on-surface-variant);
            font-size: 14px;
            line-height: 20px;
        }

        .menu {
            display: grid;
            gap: 10px;
        }

        .menu a,
        .logout-button {
            display: block;
            width: 100%;
            position: relative;
            border: 1px solid transparent;
            border-radius: var(--radius);
            padding: 12px 14px 12px 18px;
            background: transparent;
            color: var(--on-surface-variant);
            text-decoration: none;
            text-align: left;
            font-size: 14px;
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
            height: 100vh;
            overflow-y: auto;
            overflow-x: hidden;
            max-width: 1440px;
            margin: 0 auto;
            padding: 32px 24px;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .topbar,
        .panel,
        .stat-card {
            background: var(--surface-container-lowest);
            border: 1px solid var(--outline-variant);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
        }

        .topbar {
            padding: 20px 24px;
            margin-bottom: 24px;
        }

        .topbar h2 {
            margin: 0;
            color: var(--primary);
            font-size: 24px;
            font-weight: 600;
            line-height: 32px;
        }

        .topbar p {
            margin: 6px 0 0;
            color: var(--on-surface-variant);
            font-size: 14px;
            line-height: 20px;
        }

        .stats-grid,
        .charts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            position: relative;
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
            color: var(--primary);
            font-size: 24px;
            font-weight: 600;
            line-height: 32px;
        }

        .panel {
            padding: 24px;
            margin-bottom: 24px;
        }

        .panel h3 {
            margin: 0 0 18px;
            color: var(--on-surface);
            font-size: 20px;
            font-weight: 600;
            line-height: 28px;
        }

        .pie-layout {
            display: grid;
            grid-template-columns: 220px 1fr;
            gap: 20px;
            align-items: center;
        }

        .pie-chart {
            width: 220px;
            max-width: 100%;
            aspect-ratio: 1;
            border-radius: 50%;
            background: var(--surface-container);
            box-shadow: inset 0 0 0 18px var(--surface-container-lowest);
        }

        .legend {
            display: grid;
            gap: 10px;
        }

        .legend-item {
            display: grid;
            grid-template-columns: 14px 1fr auto;
            gap: 10px;
            align-items: center;
            font-size: 14px;
        }

        .legend-color {
            width: 14px;
            height: 14px;
            border-radius: 4px;
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 14px;
            margin-bottom: 16px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            color: var(--primary);
            font-weight: bold;
            font-size: 14px;
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

        .action-row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 18px;
        }

        .btn {
            border: 1px solid var(--primary);
            border-radius: var(--radius);
            padding: 10px 14px;
            border: 1px solid var(--primary);
            background: var(--primary);
            color: var(--on-primary);
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-gold {
            border-color: var(--secondary);
            background: var(--secondary);
        }

        .table-wrap {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        table {
            width: 100%;
            min-width: 820px;
            border-collapse: collapse;
            background: var(--surface-container-lowest);
        }

        th {
            background: var(--surface-container);
            color: var(--secondary);
            text-align: left;
            padding: 12px;
            font-size: 12px;
            font-weight: 600;
            line-height: 16px;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            white-space: nowrap;
        }

        td {
            border-bottom: 1px solid var(--outline-variant);
            padding: 12px;
            vertical-align: top;
            font-size: 14px;
            overflow-wrap: anywhere;
        }

        tr:nth-child(even) td {
            background: var(--surface-container-low);
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
            .shell {
                grid-template-columns: 232px minmax(0, 1fr);
            }

            .sidebar {
                padding: 20px 14px;
            }

            .content {
                padding: 22px;
            }

            .pie-layout {
                grid-template-columns: 180px minmax(0, 1fr);
            }

            .pie-chart {
                width: 180px;
            }
        }

        @media (max-width: 820px) {
            body {
                overflow: auto;
            }

            .shell {
                height: auto;
                grid-template-columns: 1fr;
            }

            .sidebar {
                padding: 16px;
                gap: 14px;
                border-right: 0;
                border-bottom: 1px solid var(--outline-variant);
            }

            .brand {
                padding-bottom: 14px;
            }

            .brand h1 {
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
                display: grid;
                gap: 8px;
                overflow-x: visible;
                padding-bottom: 0;
            }

            .menu a {
                white-space: normal;
            }

            .logout-form {
                margin-top: 0;
            }

            .logout-button {
                width: auto;
            }

            .content {
                height: auto;
                overflow: visible;
                padding: 16px;
            }

            .topbar h2 {
                font-size: 22px;
                line-height: 30px;
            }

            .panel,
            .topbar,
            .stat-card {
                padding: 18px;
            }

            .pie-layout {
                grid-template-columns: 1fr;
            }

            .pie-chart {
                width: min(220px, 100%);
                margin: 0 auto;
            }

            .action-row {
                align-items: stretch;
                flex-direction: column;
            }

            .btn {
                width: 100%;
                text-align: center;
            }
        }

        @media (max-width: 520px) {
            .sidebar,
            .content {
                padding-left: 12px;
                padding-right: 12px;
            }

            .menu {
                display: grid;
                grid-template-columns: 1fr;
                overflow-x: visible;
            }

            .menu a,
            .logout-button {
                width: 100%;
                white-space: normal;
            }

            .stats-grid,
            .charts-grid,
            .filter-grid {
                grid-template-columns: 1fr;
            }

            table {
                min-width: 720px;
            }

            th,
            td {
                padding: 10px 12px;
            }
        }
    </style>
</head>
<body>
    <div class="shell">
        <input class="nav-toggle" type="checkbox" id="kepala-menu-toggle">
        <aside class="sidebar">
            <div class="brand">
                <div class="brand-header">
                    <h1>Kepala Laboratorium</h1>
                    <label class="mobile-menu-button" for="kepala-menu-toggle" aria-label="Buka menu">
                        <span></span>
                    </label>
                </div>
                <p>{{ auth()->user()->name ?? 'Kepala Lab' }}</p>
            </div>

            <div class="mobile-menu-panel">
                <nav class="menu">
                    <a class="active" href="{{ route('kepala_lab.dashboard') }}">Dashboard</a>
                    <a href="#laporan">Laporan Kerusakan</a>
                </nav>

                <form class="logout-form" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="logout-button" type="submit">Logout</button>
                </form>
            </div>
        </aside>

        <main class="content">
            <section class="topbar">
                <span class="eyebrow">Dashboard Kepala Lab</span>
                <h2>Evaluasi Kerusakan Laboratorium</h2>
                <p>Ringkasan kondisi perangkat, tren kerusakan, dan laporan per laboratorium.</p>
            </section>

            <section class="stats-grid">
                <div class="stat-card">
                    <p>Total Laboratorium</p>
                    <strong>{{ $totalLaboratorium }}</strong>
                </div>

                <div class="stat-card">
                    <p>Total Kerusakan</p>
                    <strong>{{ $totalKerusakan }}</strong>
                </div>

                <div class="stat-card">
                    <p>Total Unit Komputer</p>
                    <strong>{{ $totalUnitKomputer }}</strong>
                </div>

                @foreach($totalPerKategori as $kategori => $total)
                    @php
                        $statusClass = match ($kategori) {
                            'Ringan' => 'status-light',
                            'Sedang' => 'status-medium',
                            'Berat' => 'status-heavy',
                            'Tidak Bisa Digunakan' => 'status-critical',
                            default => '',
                        };
                    @endphp
                    <div class="stat-card {{ $statusClass }}">
                        <p>{{ $kategori }}</p>
                        <strong>{{ $total }}</strong>
                    </div>
                @endforeach
            </section>

            <section class="charts-grid">
                <div class="panel">
                    <h3>Grafik Kerusakan Bulanan</h3>

                    <div class="pie-layout">
                        <div class="pie-chart"
                        @if($totalBulanan > 0)
                            style="background: conic-gradient(
                                @foreach($monthlySegments as $segment)
                                    {{ $segment['color'] }} {{ $segment['start'] }}% {{ $segment['end'] }}%{{ $loop->last ? '' : ',' }}
                                @endforeach
                            );"
                        @endif></div>

                        <div class="legend">
                            @foreach($monthlySegments as $segment)
                                <div class="legend-item">
                                    <span class="legend-color" style="background: {{ $segment['color'] }};"></span>
                                    <span>{{ $segment['label'] }}</span>
                                    <strong>{{ $segment['total'] }}</strong>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="panel">
                    <h3>Grafik Kerusakan Per Labor</h3>

                    <div class="pie-layout">
                        <div class="pie-chart"
                        @if($totalPerLabor > 0)
                            style="background: conic-gradient(
                                @foreach($laborSegments as $segment)
                                    {{ $segment['color'] }} {{ $segment['start'] }}% {{ $segment['end'] }}%{{ $loop->last ? '' : ',' }}
                                @endforeach
                            );"
                        @endif></div>

                        <div class="legend">
                            @foreach($laborSegments as $segment)
                                <div class="legend-item">
                                    <span class="legend-color" style="background: {{ $segment['color'] }};"></span>
                                    <span>{{ $segment['label'] }}</span>
                                    <strong>{{ $segment['total'] }}</strong>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>

            <section id="laporan" class="panel">
                <h3>Laporan Kerusakan Laboratorium</h3>

                <form method="GET" action="{{ route('kepala_lab.dashboard') }}">
                    <div class="filter-grid">
                        <div>
                            <label>Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" value="{{ $filter['tanggal_mulai'] ?? '' }}">
                        </div>

                        <div>
                            <label>Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" value="{{ $filter['tanggal_selesai'] ?? '' }}">
                        </div>

                        <div>
                            <label>Laboratorium</label>
                            <select name="laboratorium">
                                <option value="">Semua Laboratorium</option>
                                @foreach($lokasiLab as $lokasi)
                                    <option value="{{ $lokasi }}" @selected(($filter['laboratorium'] ?? '') === $lokasi)>
                                        {{ $lokasi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label>Status</label>
                            <select name="status">
                                <option value="">Semua Status</option>
                                <option value="Rusak" @selected(($filter['status'] ?? '') === 'Rusak')>Rusak</option>
                                <option value="Diproses" @selected(($filter['status'] ?? '') === 'Diproses')>Diproses</option>
                                <option value="Selesai" @selected(($filter['status'] ?? '') === 'Selesai')>Selesai</option>
                            </select>
                        </div>

                        <div>
                            <label>Kategori Kerusakan</label>
                            <select name="kategori">
                                <option value="">Semua Kategori</option>
                                @foreach($totalPerKategori as $kategori => $total)
                                    <option value="{{ $kategori }}" @selected(($filter['kategori'] ?? '') === $kategori)>
                                        {{ $kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="action-row">
                        <button class="btn btn-gold" type="submit">Filter</button>
                        <a class="btn" href="{{ route('kepala_lab.dashboard') }}">Reset</a>
                        <a class="btn" target="_blank" href="{{ route('kepala_lab.laporan.pdf', request()->query()) }}">Export PDF</a>
                        <a class="btn" href="{{ route('kepala_lab.laporan.excel', request()->query()) }}">Export Excel</a>
                    </div>
                </form>

                <div class="table-wrap">
                    <table>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Laboratorium</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Deskripsi</th>
                        </tr>

                        @forelse($kerusakan as $data)
                            @php
                                $statusClass = match ($data->jenis_kerusakan) {
                                    'Ringan' => 'light',
                                    'Sedang' => 'medium',
                                    'Berat' => 'heavy',
                                    'Tidak Bisa Digunakan' => 'critical',
                                    default => '',
                                };
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->tanggal }}</td>
                                <td>{{ $data->user->lokasi_lab ?? '-' }}</td>
                                <td>{{ $data->peralatan->kode_barang }}</td>
                                <td>{{ $data->peralatan->nama_barang }}</td>
                                <td><span class="status-pill {{ $statusClass }}">{{ $data->jenis_kerusakan }}</span></td>
                                <td><span class="status-pill">{{ $data->status }}</span></td>
                                <td>{{ $data->deskripsi }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">Tidak ada laporan sesuai filter.</td>
                            </tr>
                        @endforelse
                    </table>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
