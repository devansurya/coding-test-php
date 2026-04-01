<?php
// UserController - CRUD user, semua method memerlukan login
class UserController extends Controller
{
    private User $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->session->requireLogin();
        $this->userModel = new User();
    }

    // Daftar user
    public function index(): void
    {
        $users     = $this->userModel->getAll();
        $flash     = $this->session->getFlash();
        $csrfToken = $this->session->generateCsrfToken();

        $this->view->render('users', [
            'users'     => $users,
            'flash'     => $flash,
            'csrfToken' => $csrfToken,
            'username'  => $this->session->get('username'),
        ]);
    }

    // Form tambah user
    public function create(): void
    {
        $errors   = [];
        $username = '';

        if ($this->isPost()) {
            $result = $this->processCreate();
            if ($result === true) {
                return;
            }
            $errors   = $result['errors'];
            $username = $result['username'];
        }

        $csrfToken = $this->session->generateCsrfToken();

        $this->view->render('user_add', [
            'errors'    => $errors,
            'username'  => $username,
            'csrfToken' => $csrfToken,
        ]);
    }

    // Proses create user
    private function processCreate()
    {
        if (!$this->validateCsrf()) {
            return ['errors' => ['Sesi tidak valid. Silakan coba lagi.'], 'username' => ''];
        }

        $username = $this->postInput('username');
        $password = $_POST['password'] ?? '';
        $errors   = [];

        // Validasi input
        $usernameError = $this->userModel->validateUsername($username);
        if ($usernameError) {
            $errors[] = $usernameError;
        }

        $passwordError = $this->userModel->validatePassword($password);
        if ($passwordError) {
            $errors[] = $passwordError;
        }

        // Cek duplikat username
        if (empty($errors) && $this->userModel->getByUsername($username)) {
            $errors[] = 'Username sudah digunakan.';
        }

        // Simpan jika valid
        if (empty($errors)) {
            try {
                $this->userModel->create($username, $password);
                $this->session->setFlash('success', 'User berhasil ditambahkan.');
                $this->redirect('index.php?action=users');
                return true;
            } catch (Exception $e) {
                $errors[] = 'Gagal menambahkan user. Silakan coba lagi.';
            }
        }

        return compact('errors', 'username');
    }

    // Form edit user
    public function edit(): void
    {
        $id   = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);
        $user = $this->userModel->getById($id);

        if (!$user) {
            $this->session->setFlash('error', 'User tidak ditemukan.');
            $this->redirect('index.php?action=users');
        }

        $errors   = [];
        $username = $user['Username'];

        if ($this->isPost()) {
            $result = $this->processEdit($id);
            if ($result === true) {
                return;
            }
            $errors   = $result['errors'];
            $username = $result['username'];
        }

        $csrfToken = $this->session->generateCsrfToken();

        $this->view->render('user_edit', [
            'errors'    => $errors,
            'username'  => $username,
            'id'        => $id,
            'csrfToken' => $csrfToken,
        ]);
    }

    // Proses update user
    private function processEdit(int $id)
    {
        if (!$this->validateCsrf()) {
            return ['errors' => ['Sesi tidak valid. Silakan coba lagi.'], 'username' => ''];
        }

        $username = $this->postInput('username');
        $password = $_POST['password'] ?? '';
        $errors   = [];

        // Validasi username
        $usernameError = $this->userModel->validateUsername($username);
        if ($usernameError) {
            $errors[] = $usernameError;
        }

        // Validasi password hanya jika diisi
        if (!empty($password)) {
            $passwordError = $this->userModel->validatePassword($password);
            if ($passwordError) {
                $errors[] = $passwordError;
            }
        }

        // Cek duplikat username (kecuali diri sendiri)
        if (empty($errors)) {
            $existing = $this->userModel->getByUsername($username);
            if ($existing && $existing['Id'] !== $id) {
                $errors[] = 'Username sudah digunakan oleh user lain.';
            }
        }

        // Update jika valid
        if (empty($errors)) {
            try {
                $this->userModel->update($id, $username, $password);
                $this->session->setFlash('success', 'User berhasil diubah.');
                $this->redirect('index.php?action=users');
                return true;
            } catch (Exception $e) {
                $errors[] = 'Gagal mengubah user. Silakan coba lagi.';
            }
        }

        return compact('errors', 'username');
    }

    // Hapus user
    public function delete(): void
    {
        $id    = (int) ($this->getInput('id'));
        $token = $this->getInput('token');

        // Validasi CSRF
        if (!$this->session->validateCsrfToken($token)) {
            $this->session->setFlash('error', 'Sesi tidak valid. Silakan coba lagi.');
            $this->redirect('index.php?action=users');
        }

        if ($id <= 0) {
            $this->session->setFlash('error', 'ID user tidak valid.');
            $this->redirect('index.php?action=users');
        }

        $user = $this->userModel->getById($id);

        if (!$user) {
            $this->session->setFlash('error', 'User tidak ditemukan.');
            $this->redirect('index.php?action=users');
        }

        try {
            $this->userModel->delete($id);
            $this->session->setFlash('success', 'User "' . $user['Username'] . '" berhasil dihapus.');
        } catch (Exception $e) {
            $this->session->setFlash('error', 'Gagal menghapus user. Silakan coba lagi.');
        }

        $this->redirect('index.php?action=users');
    }
}
