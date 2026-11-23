<?php
$pageTitle = 'Login';
require __DIR__ . '/../layouts/header.php';
?>
<main class="container">
    <section class="login-container">
        <div class="login-heading">
            <h2>Login</h2>
            <p>Silakan masuk untuk mengakses sistem presensi.</p>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-error alert-compact">
                <p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
            </div>
        <?php endif; ?>

        <form method="POST" action="?route=login" class="login-form">
            <div>
                <label for="username">Username</label>
                <input
                    type="text"
                    name="username"
                    id="username"
                    placeholder="Masukkan username"
                    autocomplete="username">
            </div>
            <div>
                <label for="password">Password</label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    placeholder="Masukkan password"
                    autocomplete="current-password">
            </div>
            <button type="submit">Masuk</button>
        </form>
    </section>
</main>
<?php require __DIR__ . '/../layouts/footer.php'; ?>