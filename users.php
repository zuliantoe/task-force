<?php
require __DIR__ . '/includes/auth.php';
require_role(['admin']);
require __DIR__ . '/config/database.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_csrf();
    $id = filter_var($_POST['id'] ?? '', FILTER_VALIDATE_INT);
    $role = $_POST['role'] ?? '';
    if (!$id || !in_array($role,['admin','staff','user'],true)) {
        $error = 'Data pengguna atau role tidak valid.';
    } elseif ($id === (int)$_SESSION['user_id'] && $role !== 'admin') {
        $error = 'Admin tidak boleh menurunkan role akunnya sendiri.';
    } else {
        $stmt = $pdo->prepare('UPDATE users SET role=? WHERE id=?');
        $stmt->execute([$role,$id]);
        header('Location: users.php'); exit;
    }
}
$users = $pdo->query('SELECT id,name,email,role FROM users ORDER BY id')->fetchAll();
require __DIR__ . '/includes/header.php';
?>
<section class="card"><span class="pill">Khusus Admin</span><h1>Pengguna &amp; Role</h1><p>Admin dapat mengubah role akun. Perubahan pada akun lain berlaku setelah akun tersebut login ulang.</p>
<?php if($error): ?><div class="alert"><?= e($error) ?></div><?php endif; ?>
<div class="table-wrap"><table><thead><tr><th>Nama</th><th>Email</th><th>Role</th><th>Ubah Role</th></tr></thead><tbody>
<?php foreach ($users as $user): ?><tr><td><?= e($user['name']) ?></td><td><?= e($user['email']) ?></td><td><span class="pill"><?= e($user['role']) ?></span></td><td><form method="post" class="inline"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><input type="hidden" name="id" value="<?= (int)$user['id'] ?>"><select name="role"><?php foreach(['admin','staff','user'] as $role): ?><option value="<?= $role ?>" <?= $user['role']===$role?'selected':'' ?>><?= ucfirst($role) ?></option><?php endforeach; ?></select><button class="btn small">Simpan</button></form></td></tr><?php endforeach; ?>
</tbody></table></div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
