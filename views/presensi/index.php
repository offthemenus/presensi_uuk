<?php
$pageTitle = 'Data Presensi';
require __DIR__ . '/../layouts/header.php';
?>

<main class="container">
    <section class="page-heading">
        <div>
            <h2>Data Presensi</h2>
            <p>Berikut adalah riwayat presensi siswa.</p>
        </div>
        <span class="badge"><?= count($presences) ?> presensi</span>
    </section>

    <?php if (empty($presences)): ?>
        <div class="empty-state">
            <h3>Belum ada presensi</h3>
            <p>Data presensi siswa akan ditampilkan di sini.</p>
        </div>
    <?php else: ?>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Tanggal Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($presences as $index => $presence): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($presence['nama'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($presence['nama_kelas'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td>
                                <?= date('d-m-Y H:i', strtotime($presence['tanggal_waktu'])) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</main>

<?php require __DIR__ . '/../layouts/footer.php'; ?>