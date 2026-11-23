<?php
$pageTitle = $isEdit ? 'Edit Siswa' : 'Tambah Siswa';
require __DIR__ . '/../layouts/header.php';
?>
<main class="container">
    <section class="page-heading">
        <div>
            <h2><?= $isEdit ? 'Edit Siswa' : 'Tambah Siswa' ?></h2>
            <p><?= $isEdit ? 'Perbarui informasi siswa.' : 'Masukkan data siswa baru.' ?></p>
        </div>
        <a href="?route=siswa" class="btn-secondary">Kembali</a>
    </section>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-error alert-compact">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="?route=<?= $formAction ?>" class="student-form">
        <div>
            <label for="nisn">NISN</label>
            <input
                type="text"
                name="nisn"
                id="nisn"
                value="<?= htmlspecialchars($student['nisn'], ENT_QUOTES, 'UTF-8') ?>"
                maxlength="10"
                placeholder="Masukkan 10 digit NISN">
        </div>

        <div>
            <label for="nama">Nama Siswa</label>
            <input
                type="text"
                name="nama"
                id="nama"
                value="<?= htmlspecialchars($student['nama'], ENT_QUOTES, 'UTF-8') ?>"
                maxlength="100"
                placeholder="Masukkan nama siswa">
        </div>

        <div>
            <label for="alamat">Alamat</label>
            <textarea
                name="alamat"
                id="alamat"
                rows="3"
                maxlength="255"
                placeholder="Masukkan alamat siswa"><?= htmlspecialchars($student['alamat'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
        </div>

        <div>
            <label for="id_kelas">Kelas</label>
            <select name="id_kelas" id="id_kelas" required>
                <option value="">Pilih Kelas</option>
                <?php foreach ($classes as $class): ?>
                    <option
                        value="<?= $class['id_kelas'] ?>"
                        <?= (string) $student['id_kelas'] === (string) $class['id_kelas'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($class['nama_kelas'], ENT_QUOTES, 'UTF-8') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-actions">
            <a href="?route=siswa" class="btn-secondary">Batal</a>
            <button type="submit" class="btn-submit">
                <?= $isEdit ? 'Simpan Perubahan' : 'Tambah Siswa' ?>
            </button>
        </div>
    </form>
</main>
<?php require __DIR__ . '/../layouts/footer.php'; ?>