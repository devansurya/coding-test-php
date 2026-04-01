<?php
// Class User - CRUD pada tabel tbl_user
class User
{
    private db $db;

    public function __construct()
    {
        $this->db = db::getInstance();
    }

    // Ambil semua data user
    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT Id, Username, Password, CreateTime FROM tbl_user ORDER BY Id ASC");
        return $stmt->fetchAll();
    }

    // Ambil data user berdasarkan ID
    public function getById(int $id): ?array
    {
        $stmt = $this->db->query("SELECT Id, Username, Password, CreateTime FROM tbl_user WHERE Id = ?", [$id]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    // Ambil data user berdasarkan username
    public function getByUsername(string $username): ?array
    {
        $stmt = $this->db->query("SELECT Id, Username, Password, CreateTime FROM tbl_user WHERE Username = ?", [$username]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    // Insert user baru, password di-hash dengan bcrypt
    public function create(string $username, string $password): bool
    {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $this->db->query(
            "INSERT INTO tbl_user (Username, Password, CreateTime) VALUES (?, ?, NOW())",
            [$username, $hashedPassword]
        );
        return true;
    }

    // Update data user, password opsional
    public function update(int $id, string $username, string $password = ''): bool
    {
        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $this->db->query(
                "UPDATE tbl_user SET Username = ?, Password = ? WHERE Id = ?",
                [$username, $hashedPassword, $id]
            );
        } else {
            $this->db->query(
                "UPDATE tbl_user SET Username = ? WHERE Id = ?",
                [$username, $id]
            );
        }
        return true;
    }

    // Hapus user berdasarkan ID
    public function delete(int $id): bool
    {
        $this->db->query("DELETE FROM tbl_user WHERE Id = ?", [$id]);
        return true;
    }

    // Autentikasi user untuk login
    public function authenticate(string $username, string $password): ?array
    {
        $user = $this->getByUsername($username);

        if ($user && password_verify($password, $user['Password'])) {
            return $user;
        }
        return null;
    }

    // Validasi password: minimal 5, maksimal 8 karakter
    public function validatePassword(string $password): ?string
    {
        $len = strlen($password);
        if ($len < 5) {
            return 'Password minimal 5 karakter.';
        }
        if ($len > 8) {
            return 'Password maksimal 8 karakter.';
        }
        return null;
    }

    // Validasi username: tidak boleh kosong, maksimal 128 karakter
    public function validateUsername(string $username): ?string
    {
        if (empty(trim($username))) {
            return 'Nama tidak boleh kosong.';
        }
        if (strlen($username) > 128) {
            return 'Nama maksimal 128 karakter.';
        }
        return null;
    }
}
