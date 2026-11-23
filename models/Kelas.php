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

    public function getAll()
    {
        $query = "SELECT * FROM kelas ORDER BY id_kelas ASC";
        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
