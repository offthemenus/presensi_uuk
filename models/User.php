<?php

class User extends BaseModel
{
    public function __construct(PDO $connection)
    {
        parent::__construct($connection);
    }

    // Mengambil daftar pengguna
    public function getAll()
    {
        $query = "SELECT id_user, username FROM users ORDER BY id_user ASC";
        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Memvalidasi username dan password
    public function authenticate($username, $password)
    {
        $query = "SELECT id_user, username, password FROM users WHERE username = :username LIMIT 1";
        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute(['username' => $username]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($password, $user['password'])) {
            return false;
        }

        return [
            'id_user' => $user['id_user'],
            'username' => $user['username']
        ];
    }
}
