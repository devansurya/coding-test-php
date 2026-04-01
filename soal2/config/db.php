<?php
// Class db - koneksi ke database MySQL menggunakan PDO
class db
{
    private static ?db $instance = null;
    private PDO $connection;

    private string $host   = 'localhost';
    private string $dbname = 'user_db';
    private string $user   = 'root';
    private string $pass   = '';

    public function __construct()
    {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";
            $this->connection = new PDO($dsn, $this->user, $this->pass, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            die('Koneksi database gagal: ' . $e->getMessage());
        }
    }

    // Singleton - mendapatkan instance tunggal
    public static function getInstance(): db
    {
        if (self::$instance === null) {
            self::$instance = new db();
        }
        return self::$instance;
    }

    // Mendapatkan objek koneksi PDO
    public function getConnection(): PDO
    {
        return $this->connection;
    }

    // Menjalankan query dengan prepared statement
    public function query(string $sql, array $params = []): PDOStatement
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    // Mendapatkan ID terakhir yang di-insert
    public function lastInsertId(): string
    {
        return $this->connection->lastInsertId();
    }
}
