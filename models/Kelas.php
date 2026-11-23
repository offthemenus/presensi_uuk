<?php

class Kelas extends BaseModel
{
    public function __construct(PDO $connection)
    {
        parent::__construct($connection);
    }

    // Mengambil kelas beserta jumlah siswa
    public function getAll()
    {
        $query = "
            SELECT
                kelas.id_kelas,
                kelas.nama_kelas,
                kelas.jurusan,
                (
                    SELECT COUNT(*)
                    FROM siswa
                    WHERE siswa.id_kelas = kelas.id_kelas
                ) AS jumlah_siswa
            FROM kelas
            ORDER BY kelas.nama_kelas ASC
        ";

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

    // Memeriksa nama kelas duplikat
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
        $query = "
            INSERT INTO kelas (nama_kelas, jurusan)
            VALUES (:nama_kelas, :jurusan)
        ";

        $stmt = $this->getConnection()->prepare($query);

        return $stmt->execute([
            'nama_kelas' => $namaKelas,
            'jurusan' => $jurusan
        ]);
    }

    // Memperbarui kelas
    public function update($idKelas, $namaKelas, $jurusan)
    {
        $query = "
            UPDATE kelas
            SET nama_kelas = :nama_kelas, jurusan = :jurusan
            WHERE id_kelas = :id_kelas
        ";

        $stmt = $this->getConnection()->prepare($query);

        return $stmt->execute([
            'id_kelas' => $idKelas,
            'nama_kelas' => $namaKelas,
            'jurusan' => $jurusan
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
