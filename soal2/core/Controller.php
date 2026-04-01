<?php
// Base Controller - semua controller meng-extend class ini
abstract class Controller
{
    protected Session $session;
    protected View $view;

    public function __construct()
    {
        $this->session = Session::getInstance();
        $this->view    = new View(__DIR__ . '/../views');
    }

    // Ambil input POST yang sudah di-trim
    protected function postInput(string $key, string $default = ''): string
    {
        return trim($_POST[$key] ?? $default);
    }

    // Ambil input GET
    protected function getInput(string $key, string $default = ''): string
    {
        return trim($_GET[$key] ?? $default);
    }

    // Cek apakah request POST
    protected function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    // Redirect ke URL
    protected function redirect(string $url): void
    {
        $this->session->redirect($url);
    }

    // Validasi CSRF token dari POST
    protected function validateCsrf(): bool
    {
        $token = $this->postInput('csrf_token');
        return $this->session->validateCsrfToken($token);
    }
}
