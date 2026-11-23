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

    <?php if (empty($students)): ?>
        <div class="empty-state">
            <h3>Belum ada siswa</h3>
            <p>Tambahkan data siswa untuk menampilkannya di sini.</p>
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