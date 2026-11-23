<main class="container">
    <section class="page-heading">
        <div>
            <h2>Simulasi Tap</h2>
            <p>Masukkan NISN untuk mencatat presensi.</p>
        </div>
        <a href="?route=presensi" class="btn-secondary">Kembali</a>
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

    <form method="POST" action="?route=presensi/tap" class="student-form">
        <div>
            <label for="nisn">NISN</label>
            <input
                type="text"
                name="nisn"
                id="nisn"
                value="<?= htmlspecialchars($nisn ?? '', ENT_QUOTES, 'UTF-8') ?>"
                inputmode="numeric"
                maxlength="10"
                placeholder="Masukkan 10 digit NISN"
                required>
        </div>

        <div class="form-actions">
            <a href="?route=presensi" class="btn-secondary">Batal</a>
            <button type="submit" class="btn-submit">Simpan Presensi</button>
        </div>
    </form>
</main>