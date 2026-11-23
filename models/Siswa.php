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

    public function getAll()
    {
        $query = "
            SELECT
                siswa.nisn,
                siswa.nama,
                siswa.alamat,
                kelas.nama_kelas
            FROM siswa
            INNER JOIN kelas ON siswa.id_kelas = kelas.id_kelas
            ORDER BY siswa.nama ASC
        ";

        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
