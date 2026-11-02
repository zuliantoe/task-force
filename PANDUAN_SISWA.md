# Panduan Siswa — Praktik Task Force

## 1. Gambaran aplikasi
Task Force adalah aplikasi manajemen tugas sederhana, dibuat dengan PHP Native, MySQL, PDO, Session, HTML, dan CSS. Tujuan latihan adalah memahami **authentication** (siapa yang login) dan **authorization** (apa yang boleh diakses).

| Fitur | Admin | Staff | User |
|---|---|---|---|
| Login, logout, dashboard | Ya | Ya | Ya |
| Lihat & tambah tugas | Ya | Ya | Tidak |
| Hapus tugas | Ya | Tidak | Tidak |
| Lihat pengguna & ubah role | Ya | Tidak | Tidak |

## 2. Persiapan laptop
Siapkan Git, VS Code, PHP 8.1 atau lebih baru (aktifkan PDO MySQL dan mbstring), dan MySQL/MariaDB. Bisa menggunakan XAMPP atau Laragon di Windows; MAMP atau Herd di Mac. Pastikan PHP, MySQL, dan Git sudah tersedia. Jalankan `git --version` dan `php -v` untuk memeriksa.

## 3. Clone source code
1. Buka VS Code, pilih **Terminal → New Terminal**.
2. Masuk folder tempat menyimpan tugas.
3. Jalankan:
   ```bash
   git clone https://github.com/zuliantoe/task-force.git
   cd task-force
   code .
   ```
   Jika `code .` tidak dikenali, buka folder `task-force` secara manual di VS Code.

## 4. Siapkan database
1. Hidupkan MySQL dari XAMPP/Laragon/MAMP/Herd.
2. Buka phpMyAdmin atau DBeaver dan import `sql/database.sql`. File ini membuat database `belajar_auth` dan tabel `users` serta `tasks`.
3. Buka `config/database.php` dan sesuaikan variabel `$host`, `$dbname`, `$username`, `$password` dengan MySQL di laptop.
4. Alternatif import lewat terminal:
   ```bash
   mysql -u root -p < sql/database.sql
   ```

## 5. Buat akun contoh
Di terminal VS Code pada folder project:
```bash
php seed.php
```
Catat password acak yang muncul. Tiga akun contoh: `admin@example.test`, `staff@example.test`, `user@example.test`. Seed tidak mengubah password akun yang sudah ada.

## 6. Jalankan aplikasi
```bash
php -S localhost:8000
```
Buka `http://localhost:8000` di browser. Untuk menghentikan server tekan Ctrl+C di terminal. Server bawaan PHP hanya untuk praktikum lokal.

## 7. Praktik pengujian
1. Login Admin. Buka Dashboard, Tugas, dan Pengguna. Tambah tugas, hapus tugas, serta ubah role pengguna.
2. Logout lalu login Staff. Pastikan bisa tambah tugas tetapi tidak bisa menghapus; coba buka langsung `http://localhost:8000/users.php` dan amati HTTP 403.
3. Logout lalu login User. Pastikan hanya Dashboard yang tersedia; coba buka `tasks.php` langsung dan amati HTTP 403.
4. Logout lalu akses `dashboard.php` tanpa login. Harus diarahkan ke login.
5. Buka halaman Daftar. Daftarkan akun baru dan periksa role default-nya, yakni `user`.

## 8. File penting dan konsep
- `sql/database.sql` — tabel users dan tasks, hubungan foreign key.
- `config/database.php` — koneksi database memakai PDO.
- `register.php` — form registrasi dan `password_hash()`.
- `login.php` — pencarian user, `password_verify()`, pembuatan session.
- `includes/auth.php` — fungsi `require_login()`, `require_role()`, `has_role()`, CSRF, dan escape output.
- `dashboard.php` — halaman wajib login.
- `tasks.php` — akses admin/staff, tindakan hapus hanya admin.
- `users.php` — admin mengubah role user.
- `logout.php` — menghapus session.
- `assets/style.css` — mengatur tampilan.

## 9. Tugas latihan
A. Tambah kolom status tugas: `pending`, `proses`, `selesai`.
B. Buat fungsi edit tugas yang hanya dapat dipakai Admin dan Staff.
C. Tulis penjelasan singkat: apa beda authentication dan authorization? Kenapa menyembunyikan menu saja tidak cukup?
D. Sertakan screenshot login Admin, login Staff, login User, serta halaman 403.

## 10. Kesalahan yang sering terjadi
- **Koneksi gagal**: pastikan server MySQL hidup dan konfigurasi kredensial benar.
- **Unknown database**: import `sql/database.sql` terlebih dulu.
- **could not find driver**: aktifkan ekstensi `pdo_mysql` untuk PHP.
- **Port 8000 dipakai**: gunakan `php -S localhost:8001`.
- **Password akun contoh tidak ada**: hanya ditampilkan saat pertama kali menjalankan seed untuk akun baru.
- **git tidak dikenali**: instal Git, buka kembali terminal.
- **code tidak dikenali**: buka folder lewat menu File → Open Folder.

**Catatan keamanan:** ini aplikasi belajar, jangan dipasang langsung pada server publik. Jangan commit password database pribadi.
