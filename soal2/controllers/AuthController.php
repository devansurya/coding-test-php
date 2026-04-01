<?php
// AuthController - menangani login, logout, dan captcha
class AuthController extends Controller
{
    private User $userModel;
    private Captcha $captcha;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
        $this->captcha   = new Captcha($this->session);
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

    // Proses login
    private function processLogin(): array
    {
        $username     = $this->postInput('username');
        $password     = $_POST['password'] ?? '';
        $captchaInput = $this->postInput('captcha');
        $error        = '';
        $loginResult  = '';

        // Validasi CSRF
        if (!$this->validateCsrf()) {
            $error = 'Sesi tidak valid. Silakan coba lagi.';
        }
        // Validasi captcha
        elseif (!$this->captcha->validate($captchaInput)) {
            $error = 'Karakter Security Image tidak sesuai.';
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

    // Render gambar captcha
    public function captcha(): void
    {
        $this->captcha->render();
    }
}
