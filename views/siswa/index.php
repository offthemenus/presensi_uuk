<?php
$pageTitle = 'Daftar Siswa';
require __DIR__ . '/../layouts/header.php';
?>
<main class="container">
    <section class="page-heading">
        <div>
            <h2>Daftar Siswa</h2>
            <p>Kelola data siswa yang terdaftar.</p>
        </div>
        <a href="?route=siswa/create" class="btn-add">Tambah Siswa</a>
    </section>

    <?php if ($message): ?>
        <div class="alert alert-compact">
            <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <!-- Pencarian siswa -->
    <form method="GET">
        <input type="hidden" name="route" value="siswa">

        <div>
            <label for="search">Cari Siswa</label>
            <input
                type="text"
                name="search"
                id="search"
                value="<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>"
                placeholder="Cari nama atau NISN">
        </div>
        <button type="submit">Cari</button>
        <a href="?route=siswa" class="btn-secondary">Reset</a>
    </form>

    <!-- Tabel data siswa -->
    <?php if (empty($students)): ?>
        <div class="empty-state">
            <h3>Data siswa tidak ditemukan</h3>
            <p>Coba gunakan nama atau NISN yang berbeda.</p>
        </div>
    <?php else: ?>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NISN</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Kelas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $index => $student): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($student['nisn'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($student['nama'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($student['alamat'] ?? '-', ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($student['nama_kelas'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td>
                                <div class="table-actions">
                                    <a
                                        href="?route=siswa/edit&nisn=<?= urlencode($student['nisn']) ?>"
                                        class="btn-edit">
                                        Edit
                                    </a>
                                    <form
                                        method="POST"
                                        action="?route=siswa/delete"
                                        onsubmit="return confirm('Yakin ingin menghapus data siswa ini?')">
                                        <input type="hidden" name="nisn" value="<?= htmlspecialchars($student['nisn'], ENT_QUOTES, 'UTF-8') ?>">
                                        <button type="submit" class="btn-delete">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</main>
<?php require __DIR__ . '/../layouts/footer.php'; ?>