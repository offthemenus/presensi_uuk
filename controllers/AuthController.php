<?php

class AuthController
{
    private $userModel;

    public function __construct($userModel)
    {
        $this->userModel = $userModel;
    }

    public function login()
    {
        if (isset($_SESSION['user_id'])) {
            header('Location: ?route=presensi');
            exit;
        }

        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            $user = $this->userModel->authenticate($username, $password);

            if ($user) {
                session_regenerate_id(true);

                $_SESSION['user_id'] = $user['id_user'];
                $_SESSION['username'] = $user['username'];

                header('Location: ?route=presensi');
                exit;
            }

            $error = 'Username atau password salah.';
        }

        require __DIR__ . '/../views/auth/login.php';
    }

    public function logout()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Method Not Allowed');
        }

        $_SESSION = [];

        session_destroy();

        header('Location: ?route=login');
        exit;
    }
}
