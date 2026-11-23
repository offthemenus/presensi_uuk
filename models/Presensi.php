<?php

class Presensi
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function getAllPresences()
    {
        $query = "
            SELECT
                siswa.nama,
                kelas.nama_kelas,
                presensi.tanggal_waktu
            FROM presensi
            INNER JOIN siswa ON presensi.nisn = siswa.nisn
            INNER JOIN kelas ON siswa.id_kelas = kelas.id_kelas
            ORDER BY presensi.tanggal_waktu DESC
        ";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
