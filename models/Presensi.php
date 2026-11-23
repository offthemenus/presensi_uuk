<?php

class Presensi
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    // Mengambil log presensi berdasarkan tanggal dan kelas
    public function getAllPresences($tanggal = null, $idKelas = null)
    {
        $query = "
            SELECT
                presensi.id,
                siswa.nama,
                kelas.nama_kelas,
                presensi.tanggal_waktu
            FROM presensi
            INNER JOIN siswa ON presensi.nisn = siswa.nisn
            INNER JOIN kelas ON siswa.id_kelas = kelas.id_kelas
            WHERE 1 = 1
        ";

        $params = [];

        if (!empty($tanggal)) {
            $startDate = $tanggal . ' 00:00:00';
            $endDate = date('Y-m-d H:i:s', strtotime($tanggal . ' +1 day'));

            $query .= "
                AND presensi.tanggal_waktu >= :start_date
                AND presensi.tanggal_waktu < :end_date
            ";

            $params['start_date'] = $startDate;
            $params['end_date'] = $endDate;
        }

        if (!empty($idKelas)) {
            $query .= " AND kelas.id_kelas = :id_kelas";
            $params['id_kelas'] = $idKelas;
        }

        $query .= " ORDER BY presensi.tanggal_waktu DESC";

        $stmt = $this->connection->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    // Mengambil daftar kelas untuk filter
    public function getClasses()
    {
        $query = "
            SELECT id_kelas, nama_kelas
            FROM kelas
            ORDER BY nama_kelas ASC
        ";

        return $this->connection->query($query)->fetchAll();
    }

    // Menghapus log presensi berdasarkan ID
    public function delete($id)
    {
        $query = "DELETE FROM presensi WHERE id = :id";
        $stmt = $this->connection->prepare($query);
        $stmt->execute(['id' => $id]);

        return $stmt->rowCount() > 0;
    }
}
