<?php
require __DIR__ . '/includes/auth.php';
require_role(['admin','staff']);
require __DIR__ . '/config/database.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_csrf();
    $action = $_POST['action'] ?? '';
    if ($action === 'add') {
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        if ($title === '' || mb_strlen($title) > 150) {
            $error = 'Judul wajib diisi dan maksimal 150 karakter.';
        } else {
            $stmt = $pdo->prepare('INSERT INTO tasks (title,description,created_by) VALUES (?,?,?)');
            $stmt->execute([$title,$description,$_SESSION['user_id']]);
            header('Location: tasks.php'); exit;
        }
    } elseif ($action === 'delete') {
        require_role(['admin']);
        $id = filter_var($_POST['id'] ?? '', FILTER_VALIDATE_INT);
        if ($id) {
            $stmt = $pdo->prepare('DELETE FROM tasks WHERE id=?');
            $stmt->execute([$id]);
        }
        header('Location: tasks.php'); exit;
    }
}
$tasks = $pdo->query('SELECT tasks.*, users.name AS author FROM tasks INNER JOIN users ON users.id=tasks.created_by ORDER BY tasks.id DESC')->fetchAll();
require __DIR__ . '/includes/header.php';
?>
<section class="card"><span class="pill">Admin &amp; Staff</span><h1>Manajemen Tugas</h1><p>Admin dan Staff dapat membuat serta melihat tugas. Hanya Admin dapat menghapus.</p>
<?php if ($error): ?><div class="alert"><?= e($error) ?></div><?php endif; ?>
<form method="post"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><input type="hidden" name="action" value="add"><label>Judul Tugas<input name="title" maxlength="150" required></label><label>Deskripsi<textarea name="description" rows="3"></textarea></label><button class="btn">Tambah Tugas</button></form>
</section>
<section class="card"><h2>Daftar Tugas</h2><div class="table-wrap"><table><thead><tr><th>Judul</th><th>Deskripsi</th><th>Pembuat</th><?php if(has_role(['admin'])): ?><th>Aksi</th><?php endif; ?></tr></thead><tbody>
<?php foreach ($tasks as $task): ?><tr><td><?= e($task['title']) ?></td><td><?= e($task['description']) ?></td><td><?= e($task['author']) ?></td>
<?php if(has_role(['admin'])): ?><td><form method="post" onsubmit="return confirm('Hapus tugas ini?')"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= (int)$task['id'] ?>"><button class="danger">Hapus</button></form></td><?php endif; ?>
</tr><?php endforeach; ?>
<?php if(!$tasks): ?><tr><td colspan="4">Belum ada tugas.</td></tr><?php endif; ?></tbody></table></div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
