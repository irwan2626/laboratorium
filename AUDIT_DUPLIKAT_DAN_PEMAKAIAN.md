# Audit Duplikat dan Pemakaian File

Tanggal cek: 2026-06-22

Lingkup cek:
- `app`
- `routes`
- `resources`
- `database`
- `public`
- `config`
- `tests`

Folder `vendor`, `node_modules`, dan cache di `storage/framework/views` tidak dihitung sebagai duplikat aplikasi karena berisi dependensi dan file hasil kompilasi.

## Ringkasan

- Tidak ditemukan file aplikasi dengan isi yang persis sama.
- Ada beberapa file dengan nama sama, tetapi sebagian besar memang dipakai untuk fungsi berbeda.
- Ada beberapa file yang tidak terlihat dipakai oleh route/controller/view saat ini.

## File yang Dipakai

### Route dan Controller Utama

- `routes/web.php`
- `routes/auth.php`
- `app/Http/Controllers/HomeController.php`
- `app/Http/Controllers/DashboardController.php`
- `app/Http/Controllers/ProfileController.php`
- `app/Http/Controllers/UserController.php`
- `app/Http/Controllers/KerusakanController.php`
- `app/Http/Controllers/KepalaLabController.php`
- `app/Http/Controllers/LaboratoriumController.php`
- `app/Http/Controllers/PeralatanController.php`
- `app/Http/Controllers/KategoriKerusakanController.php`
- Semua controller di `app/Http/Controllers/Auth`

### Model yang Dipakai

- `app/Models/User.php`
- `app/Models/Kerusakan.php`
- `app/Models/Peralatan.php`
- `app/Models/Laboratorium.php`
- `app/Models/KategoriKerusakan.php`

### View yang Dipakai

- `resources/views/admin/dashboard.blade.php`
- `resources/views/admin/kategori-kerusakan/index.blade.php`
- `resources/views/admin/laboratorium/index.blade.php`
- `resources/views/admin/laporan/index.blade.php`
- `resources/views/admin/peralatan/index.blade.php`
- `resources/views/admin/users/create.blade.php`
- `resources/views/admin/users/edit.blade.php`
- `resources/views/admin/users/index.blade.php`
- `resources/views/asisten/create.blade.php`
- `resources/views/asisten/dashboard.blade.php`
- `resources/views/asisten/data-kerusakan.blade.php`
- `resources/views/asisten/edit-kerusakan.blade.php`
- `resources/views/asisten/scan.blade.php`
- `resources/views/auth/confirm-password.blade.php`
- `resources/views/auth/forgot-password.blade.php`
- `resources/views/auth/login.blade.php`
- `resources/views/auth/register.blade.php`
- `resources/views/auth/reset-password.blade.php`
- `resources/views/auth/verify-email.blade.php`
- `resources/views/kepala_lab/dashboard.blade.php`
- `resources/views/kepala_lab/exports/excel.blade.php`
- `resources/views/kepala_lab/exports/pdf.blade.php`
- `resources/views/layouts/admin.blade.php`
- `resources/views/layouts/asisten.blade.php`
- `resources/views/layouts/app.blade.php`
- `resources/views/layouts/guest.blade.php`
- `resources/views/layouts/navigation.blade.php`
- `resources/views/profile/edit.blade.php`
- `resources/views/profile/partials/delete-user-form.blade.php`
- `resources/views/profile/partials/update-password-form.blade.php`
- `resources/views/profile/partials/update-profile-information-form.blade.php`
- `resources/views/components/*.blade.php`

### Asset dan Config yang Dipakai

- `resources/css/app.css`
- `resources/js/app.js`
- `resources/js/bootstrap.js`
- `public/build/manifest.json`
- `public/build/assets/app-CSvgMtJ0.css`
- `public/build/assets/app-DsIK1Lmc.js`
- `public/images/login-bg.jpg`
- File `config/*.php`

## Nama Sama Tetapi Bukan Duplikat

- `dashboard.blade.php`
  - `resources/views/admin/dashboard.blade.php`: dipakai untuk admin.
  - `resources/views/asisten/dashboard.blade.php`: dipakai untuk asisten.
  - `resources/views/kepala_lab/dashboard.blade.php`: dipakai untuk kepala lab.
  - `resources/views/dashboard.blade.php`: tidak terlihat dipakai saat ini.
- `index.blade.php`
  - Semua file `index.blade.php` di folder admin dipakai untuk halaman berbeda.
- `auth.php`
  - `routes/auth.php`: route autentikasi.
  - `config/auth.php`: konfigurasi autentikasi Laravel.
  - Keduanya dipakai dan bukan duplikat.

## Tidak Terlihat Dipakai Saat Ini

File berikut tidak muncul di route, controller, atau referensi view aktif:

- `resources/views/welcome.blade.php`
  - Route `/` sekarang memakai `HomeController@index`.
  - `HomeController@index` mengarahkan user ke `dashboard` jika login, atau ke `login` jika belum login.
- `resources/views/dashboard.blade.php`
  - Route `/dashboard` sekarang hanya menjalankan `DashboardController@redirectByRole`.
  - File ini kemungkinan bawaan Laravel Breeze.
- `app/Http/Controllers/PerbaikanController.php`
  - Tidak ada route yang mengarah ke controller ini.
  - Isi method masih kosong.
- `app/Models/Perbaikan.php`
  - Hanya direferensikan oleh `PerbaikanController.php`.
  - Karena controller tidak dipakai, model ini juga tidak terlihat dipakai.
- `database/migrations/2026_05_09_181119_create_perbaikans_table.php`
  - Membuat tabel `perbaikans`, tetapi fitur perbaikan belum terlihat dipakai.
- `database/migrations/2026_05_09_183052_add_role_to_users_table.php`
  - Nama mirip dengan migration role sebelumnya.
  - Isi `up()` dan `down()` kosong, jadi tidak memberi efek.

## Catatan Migration Role

- `database/migrations/2026_05_09_180235_add_role_to_users_table.php` dipakai karena menambahkan kolom `role` pada tabel `users`.
- `database/migrations/2026_05_09_183052_add_role_to_users_table.php` terlihat seperti duplikat kosong dan kandidat untuk dibersihkan setelah memastikan status migration di database.

## Rekomendasi

File yang aman untuk ditinjau sebagai kandidat hapus setelah backup/cek migration:

- `resources/views/welcome.blade.php`
- `resources/views/dashboard.blade.php`
- `app/Http/Controllers/PerbaikanController.php`
- `app/Models/Perbaikan.php`
- `database/migrations/2026_05_09_181119_create_perbaikans_table.php`
- `database/migrations/2026_05_09_183052_add_role_to_users_table.php`

Sebelum menghapus migration, cek dulu apakah migration tersebut sudah tercatat di tabel `migrations`. Jika sudah pernah dijalankan, penghapusan file bisa membuat status migration di environment lain membingungkan.
