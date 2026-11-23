<?php

require_once __DIR__ . '/config/connection.php';

// Load Models
require_once __DIR__ . '/models/BaseModel.php';
require_once __DIR__ . '/models/Kelas.php';
require_once __DIR__ . '/models/Siswa.php';
require_once __DIR__ . '/models/Presensi.php';

// Load Controllers
require_once __DIR__ . '/controllers/PresensiController.php';

try {
    $database = new Connection();
    $connection = $database->getConnection();

    // Ambil URL
    $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    $requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    if ($basePath !== '' && ($requestPath === $basePath || strpos($requestPath, $basePath . '/') === 0)) {
        $requestPath = substr($requestPath, strlen($basePath));
    }

    $route = '/' . trim($requestPath, '/');

    // Routing
    switch ($route) {
        case '/':
            require __DIR__ . '/views/auth/login.php';
            break;

        case '/presensi':
            $presensiModel = new Presensi($connection);
            $kelasModel = new Kelas($connection);

            $controller = new PresensiController($presensiModel, $kelasModel);
            $controller->index();
            break;

        default:
            http_response_code(404);
            echo 'Halaman tidak ditemukan.';
            break;
    }
} catch (PDOException $e) {
    http_response_code(500);
?>
    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Presensi SMK TI Airlangga</title>
        <link rel="stylesheet" href="assets/css/style.css">
    </head>

    <body>
        <main class="container">
            <div class="alert alert-error">
                <h1>Terjadi kesalahan database</h1>
                <p>Pastikan MySQL sudah berjalan dan database <strong>presensi_uuk</strong> sudah diimpor dari <code>schema.sql</code>.</p>
                <p class="alert-detail"><?= htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') ?></p>
            </div>
        </main>
    </body>

    </html>
<?php
}
