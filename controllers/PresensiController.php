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
}
