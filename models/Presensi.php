<?php

class Presensi extends BaseModel
{
    public function __construct(PDO $connection)
    {
        parent::__construct($connection);
    }

    // Mengambil log presensi berdasarkan filter
    public function getAll($tanggal = null, $idKelas = null, $search = null)
    {
        $query = "
            SELECT
                presensi.id,
                siswa.nisn,
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

        if (!empty($search)) {
            $query .= "
            AND (siswa.nama LIKE :nama OR siswa.nisn LIKE :nisn)
        ";

            $params['nama'] = '%' . $search . '%';
            $params['nisn'] = '%' . $search . '%';
        }

        $query .= " ORDER BY presensi.tanggal_waktu DESC";

        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Menghapus log presensi berdasarkan ID
    public function delete($id)
    {
        $query = "DELETE FROM presensi WHERE id = :id";
        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute(['id' => $id]);

        return $stmt->rowCount() > 0;
    }
}
