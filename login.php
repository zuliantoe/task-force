<?php
require __DIR__ . '/includes/auth.php';
require __DIR__ . '/config/database.php';
if (is_logged_in()) { header('Location: dashboard.php'); exit; }
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_csrf();
    $email = trim($_POST['email'] ?? '');
    $password = (string)($_POST['password'] ?? '');
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = (int)$user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];
        header('Location: dashboard.php'); exit;
    }
    $error = 'Email atau password salah.';
}
require __DIR__ . '/includes/header.php';
?>
<section class="card auth"><h1>Masuk ke Task Force</h1><p>Gunakan akun yang sudah didaftarkan.</p>
<?php if ($error): ?><div class="alert"><?= e($error) ?></div><?php endif; ?>
<form method="post"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><label>Email<input name="email" type="email" required></label><label>Password<input name="password" type="password" required></label><button class="btn">Login</button></form>
<p>Belum punya akun? <a href="register.php">Daftar</a></p></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
