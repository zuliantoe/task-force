# Task Force — Latihan PHP Native

Aplikasi manajemen tugas sederhana untuk belajar **Authentication, Authorization, dan Role Access** menggunakan PHP Native, MySQL, PDO, Session, dan CSS.

## Role dan fitur
| Fitur | Admin | Staff | User |
| --- | :---: | :---: | :---: |
| Login, logout, dashboard | ✓ | ✓ | ✓ |
| Melihat & menambah tugas | ✓ | ✓ | — |
| Menghapus tugas | ✓ | — | — |
| Kelola role pengguna | ✓ | — | — |

## Mulai cepat
```bash
git clone https://github.com/zuliantoe/task-force.git
cd task-force
```
1. Import `sql/database.sql` ke MySQL/phpMyAdmin.
2. Sesuaikan `config/database.php`.
3. Jalankan `php seed.php`; catat password acak akun contoh.
4. Jalankan `php -S localhost:8000`.
5. Buka `http://localhost:8000`.

Akun contoh: `admin@example.test`, `staff@example.test`, `user@example.test`.

**Panduan siswa langkah demi langkah:** [PANDUAN_SISWA.md](PANDUAN_SISWA.md).

> Project praktikum lokal, bukan konfigurasi produksi. Pastikan ekstensi PHP `pdo_mysql` dan `mbstring` aktif.
