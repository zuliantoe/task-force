<?php
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.use_strict_mode', '1');
    session_set_cookie_params(['httponly'=>true,'secure'=>!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off','samesite'=>'Lax','path'=>'/']);
    session_start();
}
function is_logged_in(): bool { return isset($_SESSION['user_id']); }
function require_login(): void {
    if (!is_logged_in()) { header('Location: login.php'); exit; }
}
function has_role(array $roles): bool {
    return is_logged_in() && in_array($_SESSION['role'] ?? '', $roles, true);
}
function require_role(array $roles): void {
    require_login();
    if (!has_role($roles)) { http_response_code(403); require __DIR__ . '/../403.php'; exit; }
}
function e(?string $text): string { return htmlspecialchars($text ?? '', ENT_QUOTES, 'UTF-8'); }
function csrf_token(): string {
    if (empty($_SESSION['csrf_token'])) $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf_token'];
}
function check_csrf(): void {
    if (!hash_equals(csrf_token(), (string)($_POST['csrf_token'] ?? ''))) {
        http_response_code(403); exit('Token keamanan tidak cocok. Refresh halaman.');
    }
}
