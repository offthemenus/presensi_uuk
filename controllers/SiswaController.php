<?php

class SiswaController
{
    private $siswaModel;
    private $kelasModel;

    public function __construct($siswaModel, $kelasModel)
    {
        $this->siswaModel = $siswaModel;
        $this->kelasModel = $kelasModel;
    }

    public function index()
    {
        // Ambil parameter pencarian
        $search = trim($_GET['search'] ?? '');

        $students = $this->siswaModel->getAll($search);

        $message = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);

        require __DIR__ . '/../views/siswa/index.php';
    }

    public function create()
    {
        $student = [
            'nisn' => '',
            'nama' => '',
            'alamat' => '',
            'id_kelas' => ''
        ];

        $errors = [];
        $isEdit = false;

        $this->showForm($student, $errors, $isEdit);
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Method Not Allowed');
        }

        $student = $this->getInput();
        $errors = $this->validate($student);

        if (empty($errors)) {
            if ($this->siswaModel->getByNisn($student['nisn'])) {
                $errors[] = 'NISN sudah terdaftar.';
            } else {
                $this->siswaModel->create(
                    $student['nisn'],
                    $student['nama'],
                    $student['alamat'] ?: null,
                    (int) $student['id_kelas']
                );

                $_SESSION['flash'] = 'Data siswa berhasil ditambahkan.';
                header('Location: ?route=siswa');
                exit;
            }
        }

        $this->showForm($student, $errors, false);
    }

    public function edit()
    {
        $nisn = $_GET['nisn'] ?? '';
        $student = $this->siswaModel->getByNisn($nisn);

        if (!$student) {
            http_response_code(404);
            exit('Data siswa tidak ditemukan.');
        }

        $errors = [];
        $isEdit = true;

        $this->showForm($student, $errors, $isEdit);
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Method Not Allowed');
        }

        $student = $this->getInput();
        $errors = $this->validate($student);

        if (empty($errors)) {
            if (!$this->siswaModel->getByNisn($student['nisn'])) {
                http_response_code(404);
                exit('Data siswa tidak ditemukan.');
            }

            $this->siswaModel->update(
                $student['nisn'],
                $student['nama'],
                $student['alamat'] ?: null,
                (int) $student['id_kelas']
            );

            $_SESSION['flash'] = 'Data siswa berhasil diperbarui.';
            header('Location: ?route=siswa');
            exit;
        }

        $this->showForm($student, $errors, true);
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Method Not Allowed');
        }

        $nisn = $_POST['nisn'] ?? '';

        try {
            if ($this->siswaModel->delete($nisn)) {
                $_SESSION['flash'] = 'Data siswa berhasil dihapus.';
            } else {
                $_SESSION['flash'] = 'Data siswa tidak ditemukan.';
            }
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                $_SESSION['flash'] = 'Siswa tidak dapat dihapus karena masih memiliki riwayat presensi.';
            } else {
                throw $e;
            }
        }

        header('Location: ?route=siswa');
        exit;
    }

    // Mengambil input dari form
    private function getInput()
    {
        return [
            'nisn' => trim($_POST['nisn'] ?? ''),
            'nama' => trim($_POST['nama'] ?? ''),
            'alamat' => trim($_POST['alamat'] ?? ''),
            'id_kelas' => $_POST['id_kelas'] ?? ''
        ];
    }

    // Memvalidasi input siswa
    private function validate($student)
    {
        $errors = [];

        if (!preg_match('/^\d{10}$/', $student['nisn'])) {
            $errors[] = 'NISN harus terdiri dari 10 digit angka.';
        }

        if ($student['nama'] === '') {
            $errors[] = 'Nama siswa wajib diisi.';
        } elseif (strlen($student['nama']) > 100) {
            $errors[] = 'Nama siswa maksimal 100 karakter.';
        }

        if (strlen($student['alamat']) > 255) {
            $errors[] = 'Alamat maksimal 255 karakter.';
        }

        $idKelas = filter_var($student['id_kelas'], FILTER_VALIDATE_INT);

        if (!$idKelas || $idKelas < 1) {
            $errors[] = 'Silakan pilih kelas yang valid.';
        }

        return $errors;
    }

    // Menampilkan form tambah dan edit
    private function showForm($student, $errors, $isEdit)
    {
        $classes = $this->kelasModel->getAll();
        $formAction = $isEdit ? 'siswa/update' : 'siswa/store';

        require __DIR__ . '/../views/siswa/form.php';
    }
}
