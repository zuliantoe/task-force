<?php
require __DIR__ . '/includes/auth.php';
require __DIR__ . '/config/database.php';
if (is_logged_in()) { header('Location: dashboard.php'); exit; }
$error = ''; $success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_csrf();
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = (string)($_POST['password'] ?? '');
    if (!$name || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 8) {
        $error = 'Isi nama, email valid, dan password minimal 8 karakter.';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO users (name,email,password,role) VALUES (?,?,?,'user')");
            $stmt->execute([$name,$email,password_hash($password, PASSWORD_DEFAULT)]);
            $success = 'Pendaftaran berhasil. Silakan login.';
        } catch (PDOException $e) {
            $error = 'Email sudah dipakai atau database bermasalah.';
        }
    }
}
require __DIR__ . '/includes/header.php';
?>
<section class="card auth"><h1>Daftar Akun</h1><p>Akun baru otomatis mendapat role <b>user</b>.</p>
<?php if ($error): ?><div class="alert"><?= e($error) ?></div><?php endif; ?>
<?php if ($success): ?><div class="notice"><?= e($success) ?></div><?php endif; ?>
<form method="post"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><label>Nama<input name="name" required></label><label>Email<input type="email" name="email" required></label><label>Password (min. 8 karakter)<input type="password" minlength="8" name="password" required></label><button class="btn">Daftar</button></form>
<p>Sudah punya akun? <a href="login.php">Login</a></p></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
