<?php

class Siswa extends BaseModel
{
    private $nisn;
    private $nama;
    private $alamat;
    private $idKelas;

    public function __construct(PDO $connection, $nisn = null, $nama = null, $alamat = null, $idKelas = null)
    {
        parent::__construct($connection);

        $this->nisn = $nisn;
        $this->nama = $nama;
        $this->alamat = $alamat;
        $this->idKelas = $idKelas;
    }

    public function getNisn()
    {
        return $this->nisn;
    }

    public function setNisn($nisn)
    {
        $this->nisn = $nisn;
    }

    public function getNama()
    {
        return $this->nama;
    }

    public function setNama($nama)
    {
        $this->nama = $nama;
    }

    public function getAlamat()
    {
        return $this->alamat;
    }

    public function setAlamat($alamat)
    {
        $this->alamat = $alamat;
    }

    public function getIdKelas()
    {
        return $this->idKelas;
    }

    public function setIdKelas($idKelas)
    {
        $this->idKelas = $idKelas;
    }

    // Mengambil seluruh data siswa
    public function getAll()
    {
        $query = "
            SELECT
                siswa.nisn,
                siswa.nama,
                siswa.alamat,
                siswa.id_kelas,
                kelas.nama_kelas
            FROM siswa
            INNER JOIN kelas ON siswa.id_kelas = kelas.id_kelas
            ORDER BY siswa.nama ASC
        ";

        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mengambil data siswa berdasarkan NISN
    public function getByNisn($nisn)
    {
        $query = "SELECT * FROM siswa WHERE nisn = :nisn";
        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute(['nisn' => $nisn]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Menambahkan data siswa
    public function create($nisn, $nama, $alamat, $idKelas)
    {
        $this->setNisn($nisn);
        $this->setNama($nama);
        $this->setAlamat($alamat);
        $this->setIdKelas($idKelas);

        $query = "
            INSERT INTO siswa (nisn, nama, alamat, id_kelas)
            VALUES (:nisn, :nama, :alamat, :id_kelas)
        ";

        $stmt = $this->getConnection()->prepare($query);

        return $stmt->execute([
            'nisn' => $this->getNisn(),
            'nama' => $this->getNama(),
            'alamat' => $this->getAlamat(),
            'id_kelas' => $this->getIdKelas()
        ]);
    }

    // Memperbarui data siswa
    public function update($nisn, $nama, $alamat, $idKelas)
    {
        $this->setNisn($nisn);
        $this->setNama($nama);
        $this->setAlamat($alamat);
        $this->setIdKelas($idKelas);

        $query = "
            UPDATE siswa
            SET nama = :nama, alamat = :alamat, id_kelas = :id_kelas
            WHERE nisn = :nisn
        ";

        $stmt = $this->getConnection()->prepare($query);

        return $stmt->execute([
            'nisn' => $this->getNisn(),
            'nama' => $this->getNama(),
            'alamat' => $this->getAlamat(),
            'id_kelas' => $this->getIdKelas()
        ]);
    }

    // Menghapus data siswa berdasarkan NISN
    public function delete($nisn)
    {
        $query = "DELETE FROM siswa WHERE nisn = :nisn";
        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute(['nisn' => $nisn]);

        return $stmt->rowCount() > 0;
    }
}
