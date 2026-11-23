<?php
$pageTitle = $isEdit ? 'Edit Kelas' : 'Tambah Kelas';
require __DIR__ . '/../layouts/header.php';
?>
<main class="container">
    <section class="page-heading">
        <div>
            <h2><?= $isEdit ? 'Edit Kelas' : 'Tambah Kelas' ?></h2>
            <p><?= $isEdit ? 'Perbarui informasi kelas.' : 'Masukkan informasi kelas baru.' ?></p>
        </div>
        <a href="?route=kelas" class="btn-secondary">Kembali</a>
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

    <form method="POST" action="?route=<?= $formAction ?>" class="class-form">
        <?php if ($isEdit): ?>
            <input type="hidden" name="id_kelas" value="<?= (int) $class['id_kelas'] ?>">
        <?php endif; ?>

        <div>
            <label for="nama_kelas">Nama Kelas</label>
            <input
                type="text"
                name="nama_kelas"
                id="nama_kelas"
                value="<?= htmlspecialchars($class['nama_kelas'], ENT_QUOTES, 'UTF-8') ?>"
                maxlength="20"
                placeholder="Contoh: XI PPLG 1">
        </div>

        <div>
            <label for="jurusan">Jurusan</label>
            <input
                type="text"
                name="jurusan"
                id="jurusan"
                value="<?= htmlspecialchars($class['jurusan'], ENT_QUOTES, 'UTF-8') ?>"
                maxlength="50"
                placeholder="Contoh: PPLG">
        </div>

        <div class="form-actions">
            <a href="?route=kelas" class="btn-secondary">Batal</a>
            <button type="submit" class="btn-submit">
                <?= $isEdit ? 'Simpan Perubahan' : 'Tambah Kelas' ?>
            </button>
        </div>
    </form>
</main>
<?php require __DIR__ . '/../layouts/footer.php'; ?>