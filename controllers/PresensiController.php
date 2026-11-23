<?php

class PresensiController
{
    private $presensiModel;
    private $kelasModel;

    public function __construct($presensiModel, $kelasModel)
    {
        $this->presensiModel = $presensiModel;
        $this->kelasModel = $kelasModel;
    }

    public function index()
    {
        // Handle penghapusan log presensi
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);

            if ($id && $id > 0) {
                $this->presensiModel->delete($id);
            }

            header('Location: ' . $_SERVER['REQUEST_URI']);
            exit;
        }

        // Ambil parameter filter
        $tanggal = $_GET['tanggal'] ?? date('Y-m-d');
        $idKelas = $_GET['id_kelas'] ?? '';
        $search = trim($_GET['search'] ?? '');

        $presences = $this->presensiModel->getAll($tanggal, $idKelas, $search);
        $classes = $this->kelasModel->getAll();

        require __DIR__ . '/../views/presensi/index.php';
    }

    public function tap()
    {
        $pageTitle = 'Simulasi Tap';
        $nisn = '';
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nisn = trim($_POST['nisn'] ?? '');

            if (!preg_match('/^\d{10}$/', $nisn)) {
                $errors[] = 'NISN harus terdiri dari 10 digit angka.';
            } else {
                try {
                    $this->presensiModel->tap($nisn);

                    header('Location: ?route=presensi');
                    exit;
                } catch (PDOException $e) {
                    if (($e->errorInfo[1] ?? null) == 1452) {
                        $errors[] = 'NISN tidak terdaftar. Silakan daftarkan siswa terlebih dahulu.';
                    } else {
                        throw $e;
                    }
                }
            }
        }

        require __DIR__ . '/../views/layouts/header.php';
        require __DIR__ . '/../views/presensi/tap.php';
        require __DIR__ . '/../views/layouts/footer.php';
    }
}
