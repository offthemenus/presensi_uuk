<?php

class Kelas extends BaseModel
{
    private $idKelas;
    private $namaKelas;
    private $jurusan;

    public function __construct(PDO $connection, $idKelas = null, $namaKelas = null, $jurusan = null)
    {
        parent::__construct($connection);

        $this->idKelas = $idKelas;
        $this->namaKelas = $namaKelas;
        $this->jurusan = $jurusan;
    }

    public function getIdKelas()
    {
        return $this->idKelas;
    }

    public function setIdKelas($idKelas)
    {
        $this->idKelas = $idKelas;
    }

    public function getNamaKelas()
    {
        return $this->namaKelas;
    }

    public function setNamaKelas($namaKelas)
    {
        $this->namaKelas = $namaKelas;
    }

    public function getJurusan()
    {
        return $this->jurusan;
    }

    public function setJurusan($jurusan)
    {
        $this->jurusan = $jurusan;
    }

    // Mengambil seluruh data kelas
    public function getAll()
    {
        $query = "SELECT * FROM kelas ORDER BY id_kelas ASC";
        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mengambil kelas berdasarkan ID
    public function getById($idKelas)
    {
        $query = "SELECT * FROM kelas WHERE id_kelas = :id_kelas";
        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute(['id_kelas' => $idKelas]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Memeriksa apakah nama kelas sudah digunakan
    public function existsByNamaKelas($namaKelas, $excludeId = null)
    {
        $query = "SELECT COUNT(*) FROM kelas WHERE nama_kelas = :nama_kelas";
        $params = ['nama_kelas' => $namaKelas];

        if ($excludeId !== null) {
            $query .= " AND id_kelas != :id_kelas";
            $params['id_kelas'] = $excludeId;
        }

        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchColumn() > 0;
    }

    // Memeriksa apakah kelas masih memiliki siswa
    public function hasStudents($idKelas)
    {
        $query = "SELECT COUNT(*) FROM siswa WHERE id_kelas = :id_kelas";
        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute(['id_kelas' => $idKelas]);

        return $stmt->fetchColumn() > 0;
    }

    // Menambahkan kelas
    public function create($namaKelas, $jurusan)
    {
        $this->setNamaKelas($namaKelas);
        $this->setJurusan($jurusan);

        $query = "
            INSERT INTO kelas (nama_kelas, jurusan)
            VALUES (:nama_kelas, :jurusan)
        ";

        $stmt = $this->getConnection()->prepare($query);

        return $stmt->execute([
            'nama_kelas' => $this->getNamaKelas(),
            'jurusan' => $this->getJurusan()
        ]);
    }

    // Memperbarui kelas
    public function update($idKelas, $namaKelas, $jurusan)
    {
        $this->setIdKelas($idKelas);
        $this->setNamaKelas($namaKelas);
        $this->setJurusan($jurusan);

        $query = "
            UPDATE kelas
            SET nama_kelas = :nama_kelas, jurusan = :jurusan
            WHERE id_kelas = :id_kelas
        ";

        $stmt = $this->getConnection()->prepare($query);

        return $stmt->execute([
            'id_kelas' => $this->getIdKelas(),
            'nama_kelas' => $this->getNamaKelas(),
            'jurusan' => $this->getJurusan()
        ]);
    }

    // Menghapus kelas
    public function delete($idKelas)
    {
        $query = "DELETE FROM kelas WHERE id_kelas = :id_kelas";
        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute(['id_kelas' => $idKelas]);

        return $stmt->rowCount() > 0;
    }
}
