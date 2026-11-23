<?php

class KelasController
{
    private $kelasModel;

    public function __construct($kelasModel)
    {
        $this->kelasModel = $kelasModel;
    }

    public function index()
    {
        $classes = $this->kelasModel->getAll();

        $message = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);

        require __DIR__ . '/../views/kelas/index.php';
    }

    public function create()
    {
        $class = [
            'id_kelas' => '',
            'nama_kelas' => '',
            'jurusan' => ''
        ];

        $this->showForm($class, [], false);
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Method Not Allowed');
        }

        $class = $this->getInput();
        $errors = $this->validate($class);

        if (empty($errors)) {
            if ($this->kelasModel->existsByNamaKelas($class['nama_kelas'])) {
                $errors[] = 'Nama kelas sudah digunakan.';
            } else {
                try {
                    $this->kelasModel->create(
                        $class['nama_kelas'],
                        $class['jurusan']
                    );

                    $_SESSION['flash'] = 'Kelas berhasil ditambahkan.';
                    header('Location: ?route=kelas');
                    exit;
                } catch (PDOException $e) {
                    if ($this->isDuplicateEntry($e)) {
                        $errors[] = 'Nama kelas sudah digunakan.';
                    } else {
                        throw $e;
                    }
                }
            }
        }

        $this->showForm($class, $errors, false);
    }

    public function edit()
    {
        $idKelas = filter_var($_GET['id_kelas'] ?? null, FILTER_VALIDATE_INT);
        $class = $idKelas ? $this->kelasModel->getById($idKelas) : false;

        if (!$class) {
            $_SESSION['flash'] = 'Data kelas tidak ditemukan.';
            header('Location: ?route=kelas');
            exit;
        }

        $this->showForm($class, [], true);
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Method Not Allowed');
        }

        $class = $this->getInput();
        $idKelas = filter_var($class['id_kelas'], FILTER_VALIDATE_INT);

        if (!$idKelas || !$this->kelasModel->getById($idKelas)) {
            $_SESSION['flash'] = 'Data kelas tidak ditemukan.';
            header('Location: ?route=kelas');
            exit;
        }

        $errors = $this->validate($class);

        if (empty($errors)) {
            if ($this->kelasModel->existsByNamaKelas($class['nama_kelas'], $idKelas)) {
                $errors[] = 'Nama kelas sudah digunakan oleh kelas lain.';
            } else {
                try {
                    $this->kelasModel->update(
                        $idKelas,
                        $class['nama_kelas'],
                        $class['jurusan']
                    );

                    $_SESSION['flash'] = 'Data kelas berhasil diperbarui.';
                    header('Location: ?route=kelas');
                    exit;
                } catch (PDOException $e) {
                    if ($this->isDuplicateEntry($e)) {
                        $errors[] = 'Nama kelas sudah digunakan oleh kelas lain.';
                    } else {
                        throw $e;
                    }
                }
            }
        }

        $class['id_kelas'] = $idKelas;
        $this->showForm($class, $errors, true);
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Method Not Allowed');
        }

        $idKelas = filter_var($_POST['id_kelas'] ?? null, FILTER_VALIDATE_INT);

        if (!$idKelas || $idKelas < 1) {
            $_SESSION['flash'] = 'Data kelas tidak valid.';
            header('Location: ?route=kelas');
            exit;
        }

        if (!$this->kelasModel->getById($idKelas)) {
            $_SESSION['flash'] = 'Data kelas tidak ditemukan.';
            header('Location: ?route=kelas');
            exit;
        }

        if ($this->kelasModel->hasStudents($idKelas)) {
            $_SESSION['flash'] = 'Kelas tidak dapat dihapus karena masih memiliki siswa.';
            header('Location: ?route=kelas');
            exit;
        }

        try {
            $this->kelasModel->delete($idKelas);
            $_SESSION['flash'] = 'Kelas berhasil dihapus.';
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                $_SESSION['flash'] = 'Kelas tidak dapat dihapus karena masih memiliki siswa.';
            } else {
                throw $e;
            }
        }

        header('Location: ?route=kelas');
        exit;
    }

    // Mengambil input dari form
    private function getInput()
    {
        return [
            'id_kelas' => $_POST['id_kelas'] ?? '',
            'nama_kelas' => trim($_POST['nama_kelas'] ?? ''),
            'jurusan' => trim($_POST['jurusan'] ?? '')
        ];
    }

    // Memvalidasi input kelas
    private function validate($class)
    {
        $errors = [];

        if ($class['nama_kelas'] === '') {
            $errors[] = 'Nama kelas wajib diisi.';
        } elseif (strlen($class['nama_kelas']) > 20) {
            $errors[] = 'Nama kelas maksimal 20 karakter.';
        }

        if ($class['jurusan'] === '') {
            $errors[] = 'Jurusan wajib diisi.';
        } elseif (strlen($class['jurusan']) > 50) {
            $errors[] = 'Jurusan maksimal 50 karakter.';
        }

        return $errors;
    }

    // Memeriksa error duplikasi dari database
    private function isDuplicateEntry(PDOException $e)
    {
        return isset($e->errorInfo[1]) && (int) $e->errorInfo[1] === 1062;
    }

    // Menampilkan form tambah dan edit
    private function showForm($class, $errors, $isEdit)
    {
        $formAction = $isEdit ? 'kelas/update' : 'kelas/store';

        require __DIR__ . '/../views/kelas/form.php';
    }
}
