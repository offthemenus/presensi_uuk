<?php
$pageTitle = 'Log Presensi';
require __DIR__ . '/../layouts/header.php';
?>
<main class="container">
    <section class="page-heading">
        <div>
            <h2>Log Presensi</h2>
            <p>Riwayat presensi siswa.</p>
        </div>
        <div class="page-actions">
            <span class="badge"><?= count($presences) ?> presensi</span>
            <a href="?route=presensi/tap" class="btn-add">
                Simulasi Tap
            </a>
        </div>
        <form method="POST" action="?route=presensi" id="tapForm" hidden>
            <input type="hidden" name="action" value="tap">
            <input type="hidden" name="nisn" id="tapNisn">
        </form>
    </section>

    <!-- Filter dan pencarian presensi -->
    <form method="GET">
        <input type="hidden" name="route" value="presensi">

        <div>
            <label for="search">Cari Siswa</label>
            <input
                type="text"
                name="search"
                id="search"
                value="<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>"
                placeholder="Cari nama atau NISN">
        </div>
        <div>
            <label for="tanggal">Tanggal</label>
            <input
                type="date"
                name="tanggal"
                id="tanggal"
                value="<?= htmlspecialchars($tanggal, ENT_QUOTES, 'UTF-8') ?>">
        </div>
        <div>
            <label for="id_kelas">Kelas</label>
            <select name="id_kelas" id="id_kelas">
                <option value="">Semua Kelas</option>
                <?php foreach ($classes as $class): ?>
                    <option
                        value="<?= $class['id_kelas'] ?>"
                        <?= (string) $idKelas === (string) $class['id_kelas'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($class['nama_kelas'], ENT_QUOTES, 'UTF-8') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit">Cari</button>
        <a href="?route=presensi" class="btn-secondary">Reset</a>
    </form>

    <!-- Tabel riwayat presensi -->
    <?php if (empty($presences)): ?>
        <div class="empty-state">
            <h3>Log presensi kosong</h3>
            <p>Tidak ada data presensi yang sesuai dengan pencarian.</p>
        </div>
    <?php else: ?>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Tanggal Waktu</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($presences as $index => $presence): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($presence['nisn'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($presence['nama'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($presence['nama_kelas'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= date('d-m-Y H:i', strtotime($presence['tanggal_waktu'])) ?></td>
                            <td>
                                <form method="POST" onsubmit="return confirm('Yakin ingin menghapus log presensi ini?')">
                                    <input type="hidden" name="id" value="<?= (int) $presence['id'] ?>">
                                    <button type="submit" class="btn-delete">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</main>
<?php require __DIR__ . '/../layouts/footer.php'; ?>