<?php
if (PHP_SAPI !== 'cli') { http_response_code(403); exit('Gunakan terminal.'); }
require __DIR__ . '/config/database.php';
foreach (['admin','staff','user'] as $role) {
    $email = "$role@example.test";
    $stmt = $pdo->prepare('SELECT id FROM users WHERE email=?');
    $stmt->execute([$email]);
    if ($stmt->fetch()) { echo "Sudah ada: $email\n"; continue; }
    $pass = bin2hex(random_bytes(6));
    $stmt = $pdo->prepare('INSERT INTO users(name,email,password,role) VALUES(?,?,?,?)');
    $stmt->execute([ucfirst($role),$email,password_hash($pass,PASSWORD_DEFAULT),$role]);
    echo "$email | password: $pass | role: $role\n";
}
