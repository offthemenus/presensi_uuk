<?php

class Siswa extends BaseModel
{
    public function __construct(PDO $connection)
    {
        parent::__construct($connection);
    }

    // Mengambil data siswa berdasarkan pencarian
    public function getAll($search = null)
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
            WHERE 1 = 1
        ";

        $params = [];

        if (!empty($search)) {
            $query .= " AND (siswa.nama LIKE :nama OR siswa.nisn LIKE :nisn)";
            $params['nama'] = '%' . $search . '%';
            $params['nisn'] = '%' . $search . '%';
        }

        $query .= " ORDER BY siswa.nama ASC";

        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mengambil siswa berdasarkan NISN
    public function getByNisn($nisn)
    {
        $query = "SELECT * FROM siswa WHERE nisn = :nisn";
        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute(['nisn' => $nisn]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Menambahkan siswa
    public function create($nisn, $nama, $alamat, $idKelas)
    {
        $query = "
            INSERT INTO siswa (nisn, nama, alamat, id_kelas)
            VALUES (:nisn, :nama, :alamat, :id_kelas)
        ";

        $stmt = $this->getConnection()->prepare($query);

        return $stmt->execute([
            'nisn' => $nisn,
            'nama' => $nama,
            'alamat' => $alamat,
            'id_kelas' => $idKelas
        ]);
    }

    // Memperbarui data siswa
    public function update($nisn, $nama, $alamat, $idKelas)
    {
        $query = "
            UPDATE siswa
            SET nama = :nama, alamat = :alamat, id_kelas = :id_kelas
            WHERE nisn = :nisn
        ";

        $stmt = $this->getConnection()->prepare($query);

        return $stmt->execute([
            'nisn' => $nisn,
            'nama' => $nama,
            'alamat' => $alamat,
            'id_kelas' => $idKelas
        ]);
    }

    // Menghapus siswa
    public function delete($nisn)
    {
        $query = "DELETE FROM siswa WHERE nisn = :nisn";
        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute(['nisn' => $nisn]);

        return $stmt->rowCount() > 0;
    }
}
