<?php

class PresensiController
{
    private $presensiModel;

    public function __construct($presensiModel)
    {
        $this->presensiModel = $presensiModel;
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

        // Ambil data untuk View
        $presences = $this->presensiModel->getAllPresences($tanggal, $idKelas);
        $classes = $this->presensiModel->getClasses();

        require __DIR__ . '/../views/presensi/index.php';
    }
}
