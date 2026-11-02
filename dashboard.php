<?php require __DIR__ . '/includes/auth.php'; require_login(); require __DIR__ . '/includes/header.php'; ?>
<section class="card"><span class="pill">Dashboard</span><h1>Halo, <?= e($_SESSION['name']) ?>!</h1><p>Anda login sebagai <strong><?= e($_SESSION['role']) ?></strong>.</p><p>Halaman ini dapat dibuka oleh semua role yang sudah login.</p></section>
<div class="cards"><article class="card"><h3>Autentikasi</h3><p>Session membuktikan bahwa pengguna berhasil login.</p></article><article class="card"><h3>Otorisasi</h3><p>Menu dan aksi dibatasi berdasarkan role.</p></article></div>
<?php require __DIR__ . '/includes/footer.php'; ?>
