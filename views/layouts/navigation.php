<?php
$route = $_GET['route'] ?? 'login';

$isPresensi = $route === 'presensi';
$isSiswa = strpos($route, 'siswa') === 0;
$isKelas = strpos($route, 'kelas') === 0;
?>

<?php if (isset($_SESSION['user_id'])): ?>
    <nav class="workspace-nav container">
        <div class="nav-brand">
            <span>WORKSPACE</span>
            <strong>Presensi UUK</strong>
        </div>

        <div class="nav-links">
            <a href="?route=presensi" class="<?= $isPresensi ? 'active' : '' ?>" <?= $isPresensi ? 'aria-current="page"' : '' ?>>
                <span>01</span>
                Presensi
            </a>
            <a href="?route=siswa" class="<?= $isSiswa ? 'active' : '' ?>" <?= $isSiswa ? 'aria-current="page"' : '' ?>>
                <span>02</span>
                Siswa
            </a>
            <a href="?route=kelas" class="<?= $isKelas ? 'active' : '' ?>" <?= $isKelas ? 'aria-current="page"' : '' ?>>
                <span>03</span>
                Kelas
            </a>
        </div>

        <div class="nav-account">
            <span><?= htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8') ?></span>
            <form method="POST" action="?route=logout">
                <button type="submit">Keluar</button>
            </form>
        </div>
    </nav>
<?php endif; ?>