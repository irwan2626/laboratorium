<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KerusakanController;
use App\Http\Controllers\KepalaLabController;
use App\Http\Controllers\LaboratoriumController;
use App\Http\Controllers\PeralatanController;
use App\Http\Controllers\KategoriKerusakanController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

if (! function_exists('kerusakanPlaceholderResponse')) {
    function kerusakanPlaceholderResponse()
    {
        $placeholder = <<<'SVG'
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 240 180" role="img" aria-label="Foto belum tersedia">
    <rect width="240" height="180" rx="18" fill="#eef2ff"/>
    <path d="M52 128l40-42 27 28 18-18 51 52H52z" fill="#c7d2fe"/>
    <circle cx="159" cy="65" r="20" fill="#93c5fd"/>
    <text x="120" y="158" text-anchor="middle" font-family="Arial, sans-serif" font-size="18" fill="#334155">Foto tidak ditemukan</text>
</svg>
SVG;

        return response($placeholder, 200, [
                'Content-Type' => 'image/svg+xml',
                'Cache-Control' => 'no-cache',
        ]);
    }
}

Route::get('/uploads/{path}', function (string $path) {
        $path = ltrim(rawurldecode($path), '/\\');

        if ($path === '' || str_contains($path, '..') || str_contains($path, "\0")) {
                return kerusakanPlaceholderResponse();
        }

        $locations = [
                base_path('uploads/'.$path),
                base_path('public/uploads/'.$path),
                base_path('public/storage/'.$path),
                Storage::disk('public')->path($path),
        ];

        foreach ($locations as $location) {
                if (is_file($location) && is_readable($location)) {
                        $mimeType = File::mimeType($location) ?: 'application/octet-stream';

                        return response(File::get($location), 200, [
                                'Content-Type' => $mimeType,
                                'Content-Length' => File::size($location),
                                'Cache-Control' => 'public, max-age=86400',
                        ]);
                }
        }

        return kerusakanPlaceholderResponse();
})->where('path', '.*');

Route::get('/manifest.webmanifest', function () {
        return response()->json([
                'name' => 'Pendataan Laboratorium',
                'short_name' => 'Pendataan Lab',
                'start_url' => '/dashboard',
                'scope' => '/',
                'display' => 'standalone',
                'background_color' => '#f9f9ff',
                'theme_color' => '#00355f',
                'description' => 'Aplikasi pendataan laboratorium, kerusakan alat, dan manajemen pengguna.',
                'icons' => [
                        [
                                'src' => '/pwa/icon-192.svg',
                                'sizes' => '192x192',
                                'type' => 'image/svg+xml',
                                'purpose' => 'any',
                        ],
                        [
                                'src' => '/pwa/icon-512.svg',
                                'sizes' => '512x512',
                                'type' => 'image/svg+xml',
                                'purpose' => 'any',
                        ],
                ],
        ], 200, [
                'Content-Type' => 'application/manifest+json',
                'Cache-Control' => 'no-cache',
        ]);
});

Route::get('/sw.js', function () {
        $script = <<<'JS'
const CACHE_NAME = 'pendataan-lab-v2';
const APP_SHELL = [
    '/',
    '/dashboard',
    '/manifest.webmanifest',
    '/pwa/icon-192.svg',
    '/pwa/icon-512.svg'
];

self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME).then(cache => cache.addAll(APP_SHELL))
    );
    self.skipWaiting();
});

self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(keys => Promise.all(
            keys.filter(key => key !== CACHE_NAME).map(key => caches.delete(key))
        ))
    );
    self.clients.claim();
});

self.addEventListener('fetch', event => {
    if (event.request.method !== 'GET') {
        return;
    }

    event.respondWith(
        fetch(event.request)
            .then(response => {
                const responseClone = response.clone();
                caches.open(CACHE_NAME).then(cache => cache.put(event.request, responseClone));
                return response;
            })
            .catch(() => caches.match(event.request).then(cached => cached || caches.match('/dashboard')))
    );
});
JS;

        return response($script, 200, [
                'Content-Type' => 'application/javascript',
                'Cache-Control' => 'no-cache',
        ]);
});

Route::get('/pwa/icon-192.svg', function () {
        $icon = <<<'SVG'
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 192" role="img" aria-label="Pendataan Laboratorium">
    <defs>
        <linearGradient id="g" x1="0" x2="1" y1="0" y2="1">
            <stop offset="0%" stop-color="#0f4c81"/>
            <stop offset="100%" stop-color="#25736f"/>
        </linearGradient>
    </defs>
    <rect width="192" height="192" rx="44" fill="url(#g)"/>
    <rect x="40" y="38" width="112" height="116" rx="22" fill="#ffffff" opacity="0.18"/>
    <path d="M61 70h70M61 96h70M61 122h44" stroke="#ffffff" stroke-width="12" stroke-linecap="round"/>
    <circle cx="136" cy="122" r="10" fill="#c97724"/>
</svg>
SVG;

        return response($icon, 200, [
                'Content-Type' => 'image/svg+xml',
                'Cache-Control' => 'public, max-age=86400',
        ]);
});

Route::get('/pwa/icon-512.svg', function () {
        $icon = <<<'SVG'
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" role="img" aria-label="Pendataan Laboratorium">
    <defs>
        <linearGradient id="g" x1="0" x2="1" y1="0" y2="1">
            <stop offset="0%" stop-color="#0f4c81"/>
            <stop offset="100%" stop-color="#25736f"/>
        </linearGradient>
    </defs>
    <rect width="512" height="512" rx="118" fill="url(#g)"/>
    <rect x="106" y="102" width="300" height="308" rx="58" fill="#ffffff" opacity="0.18"/>
    <path d="M158 176h196M158 254h196M158 332h126" stroke="#ffffff" stroke-width="28" stroke-linecap="round"/>
    <circle cx="340" cy="332" r="24" fill="#c97724"/>
</svg>
SVG;

        return response($icon, 200, [
                'Content-Type' => 'image/svg+xml',
                'Cache-Control' => 'public, max-age=86400',
        ]);
});

Route::get('/', [HomeController::class, 'index']);

Route::get('/kerusakan/foto/{path}', [KerusakanController::class, 'foto'])
        ->where('path', '.*')
        ->name('kerusakan.foto');

Route::get('/dashboard', [DashboardController::class, 'redirectByRole'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');

    Route::get('/admin/laboratorium', [LaboratoriumController::class, 'index'])->name('admin.laboratorium.index');
    Route::get('/admin/peralatan', [PeralatanController::class, 'index'])->name('admin.peralatan.index');
    Route::get('/admin/kategori-kerusakan', [KategoriKerusakanController::class, 'index'])->name('admin.kategori-kerusakan.index');
    Route::get('/admin/laporan', [KerusakanController::class, 'laporan'])->name('admin.laporan.index');
    Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::resource('users', UserController::class);
});

Route::middleware(['auth', 'role:asisten'])->group(function () {
    Route::get('/asisten/dashboard', [KerusakanController::class, 'dashboard'])->name('asisten.dashboard');
    Route::get('/scan', [KerusakanController::class, 'scan']);
    Route::get('/kerusakan/create/{kode}', [KerusakanController::class, 'create']);
    Route::post('/kerusakan/store', [KerusakanController::class, 'store']);
    Route::get('/kerusakan/{kerusakan}/edit', [KerusakanController::class, 'edit']);
    Route::put('/kerusakan/{kerusakan}', [KerusakanController::class, 'update']);
    Route::delete('/kerusakan/{kerusakan}', [KerusakanController::class, 'destroy']);
    Route::get('/data-kerusakan', [KerusakanController::class, 'dataKerusakan']);
});

Route::middleware(['auth', 'role:kepala_lab'])->group(function () {
    Route::get('/kepala_lab/dashboard', [KepalaLabController::class, 'dashboard'])->name('kepala_lab.dashboard');
    Route::get('/kepala_lab/laporan', [KepalaLabController::class, 'laporan'])->name('kepala_lab.laporan');
    Route::get('/kepala_lab/laporan/export-excel', [KepalaLabController::class, 'exportExcel'])->name('kepala_lab.laporan.excel');
    Route::get('/kepala_lab/laporan/export-pdf', [KepalaLabController::class, 'exportPdf'])->name('kepala_lab.laporan.pdf');
});

require __DIR__.'/auth.php';
