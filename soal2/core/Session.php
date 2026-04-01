<?php
// Class Session - mengelola session, auth, CSRF, flash message
class Session
{
    private static ?Session $instance = null;

    private function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Singleton
    public static function getInstance(): Session
    {
        if (self::$instance === null) {
            self::$instance = new Session();
        }
        return self::$instance;
    }

    // Cek apakah user sudah login
    public function isLoggedIn(): bool
    {
        return !empty($_SESSION['user_id']);
    }

    // Redirect ke login jika belum login
    public function requireLogin(): void
    {
        if (!$this->isLoggedIn()) {
            $this->redirect('index.php');
        }
    }

    // Set data login ke session
    public function login(int $userId, string $username): void
    {
        session_regenerate_id(true);
        $_SESSION['user_id']  = $userId;
        $_SESSION['username'] = $username;
    }

    // Hapus session dan logout
    public function logout(): void
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        session_destroy();
    }

    // Ambil data session
    public function get(string $key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    // Set data session
    public function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    // Hapus data session
    public function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    // Generate CSRF token
    public function generateCsrfToken(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    // Validasi CSRF token
    public function validateCsrfToken(string $token): bool
    {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }

    // Set flash message
    public function setFlash(string $type, string $message): void
    {
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    }

    // Ambil dan hapus flash message
    public function getFlash(): ?array
    {
        if (isset($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);
            return $flash;
        }
        return null;
    }

    // Redirect ke URL
    public function redirect(string $url): void
    {
        header("Location: $url");
        exit;
    }
}
