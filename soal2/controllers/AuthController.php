<?php
// AuthController - menangani login dan logout
class AuthController extends Controller
{
    private User $userModel;
    private const RECAPTCHA_SECRET = '6LeJtbUsAAAAAMVRlr2NVSpk_O32d-I5eFYGSgtf';

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
    }

    // Halaman login
    public function login(): void
    {
        if ($this->session->isLoggedIn()) {
            $this->redirect('index.php?action=users');
        }

        $error       = '';
        $loginResult = '';
        $username    = '';

        if ($this->isPost()) {
            $result = $this->processLogin();
            $error       = $result['error'];
            $loginResult = $result['loginResult'];
            $username    = $result['username'];
        }

        $csrfToken = $this->session->generateCsrfToken();

        $this->view->render('login', [
            'error'       => $error,
            'loginResult' => $loginResult,
            'username'    => $username,
            'csrfToken'   => $csrfToken,
        ]);
    }

    // Verifikasi Google reCAPTCHA
    private function verifyRecaptcha(): bool
    {
        $token = $_POST['g-recaptcha-response'] ?? '';
        if (empty($token)) {
            return false;
        }

        $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?' . http_build_query([
            'secret'   => self::RECAPTCHA_SECRET,
            'response' => $token,
            'remoteip' => $_SERVER['REMOTE_ADDR'] ?? '',
        ]));

        if ($response === false) {
            return false;
        }

        $data = json_decode($response, true);
        return !empty($data['success']);
    }

    // Proses login
    private function processLogin(): array
    {
        $username    = $this->postInput('username');
        $password    = $_POST['password'] ?? '';
        $error       = '';
        $loginResult = '';

        // Validasi CSRF
        if (!$this->validateCsrf()) {
            $error = 'Sesi tidak valid. Silakan coba lagi.';
        }
        // Validasi reCAPTCHA
        elseif (!$this->verifyRecaptcha()) {
            $error = 'Verifikasi reCAPTCHA gagal. Silakan coba lagi.';
        }
        // Validasi input
        elseif (empty($username) || empty($password)) {
            $error = 'Nama dan Password harus diisi.';
        }
        // Proses autentikasi
        else {
            $user = $this->userModel->authenticate($username, $password);

            if ($user) {
                $this->session->login($user['Id'], $user['Username']);
                $loginResult = 'LOGIN SUKSES';
                header("Refresh: 1; URL=index.php?action=users");
            } else {
                $loginResult = 'LOGIN GAGAL';
            }
        }

        return compact('error', 'loginResult', 'username');
    }

    // Logout
    public function logout(): void
    {
        $this->session->logout();
        $this->redirect('index.php');
    }
}
