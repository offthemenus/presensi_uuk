<?php

require_once 'config/connection.php';
require_once 'models/Presensi.php';
require_once 'controllers/PresensiController.php';

try {
    $connection = new Connection();
    $presensiModel = new Presensi($connection->getConnection());
    $controller = new PresensiController($presensiModel);

    $controller->index();
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
                <p class="alert-detail"><?= htmlspecialchars($e->getMessage()) ?></p>
            </div>
        </main>
    </body>

    </html>
<?php
}
