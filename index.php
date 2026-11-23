<?php

require_once 'config/connection.php';

try {
    $connection = new Connection();
    $connection->getConnection();
    echo 'Koneksi berhasil';
} catch (PDOException $e) {
    http_response_code(500);
?>
    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Presensi SMK TI Airlangga</title>
    </head>

    <body>
        <main>
            <h1>Terjadi kesalahan database</h1>
            <p>Pastikan MySQL sudah berjalan dan database <strong>presensi_uuk</strong> sudah diimpor dari <code>schema.sql</code>.</p>
            <p class="alert-detail"><?= htmlspecialchars($e->getMessage()) ?></p>
        </main>
    </body>

    </html>
<?php
}
