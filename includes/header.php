<?php require_once __DIR__ . '/auth.php'; ?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Task Force</title><link rel="stylesheet" href="assets/style.css"></head>
<body><header class="top"><nav><a class="brand" href="index.php">Task Force</a><div class="links">
<?php if (is_logged_in()): ?>
<a href="dashboard.php">Dashboard</a>
<?php if (has_role(['admin','staff'])): ?><a href="tasks.php">Tugas</a><?php endif; ?>
<?php if (has_role(['admin'])): ?><a href="users.php">Pengguna</a><?php endif; ?>
<a href="logout.php">Logout</a>
<?php else: ?><a href="login.php">Login</a><a href="register.php">Daftar</a><?php endif; ?>
</div></nav></header><main class="container">
