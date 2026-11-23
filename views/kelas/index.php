<?php
$pageTitle = 'Daftar Kelas';
require __DIR__ . '/../layouts/header.php';
?>
<main class="container">
    <section class="page-heading">
        <div>
            <h2>Daftar Kelas</h2>
            <p>Kelola data kelas yang tersedia.</p>
        </div>
        <a href="?route=kelas/create" class="btn-add">Tambah Kelas</a>
    </section>

    <?php if ($message): ?>
        <div class="alert alert-compact">
            <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <?php if (empty($classes)): ?>
        <div class="empty-state">
            <h3>Belum ada kelas</h3>
            <p>Tambahkan data kelas untuk menampilkannya di sini.</p>
        </div>
    <?php else: ?>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kelas</th>
                        <th>Jurusan</th>
                        <th>Jumlah Siswa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($classes as $index => $class): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($class['nama_kelas'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($class['jurusan'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= (int) $class['jumlah_siswa'] ?> siswa</td>
                            <td>
                                <div class="table-actions">
                                    <a
                                        href="?route=kelas/edit&id_kelas=<?= (int) $class['id_kelas'] ?>"
                                        class="btn-edit">
                                        Edit
                                    </a>
                                    <form
                                        method="POST"
                                        action="?route=kelas/delete"
                                        onsubmit="return confirm('Yakin ingin menghapus kelas ini?')">
                                        <input type="hidden" name="id_kelas" value="<?= (int) $class['id_kelas'] ?>">
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