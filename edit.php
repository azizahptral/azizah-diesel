<?php
require_once 'config/database.php';

$errors = [];
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) die('ID produk tidak valid.');

$stmt = $pdo->prepare('SELECT id, name, category, price, stock FROM products WHERE id = ?');
$stmt->execute([$id]);
$product = $stmt->fetch();
if (!$product) die('Produk tidak ditemukan.');

$name = $product['name'];
$category = $product['category'];
$price = $product['price'];
$stock = $product['stock'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $price = $_POST['price'] ?? '';
    $stock = $_POST['stock'] ?? '';

    if (mb_strlen($name) < 3) $errors[] = 'Nama produk minimal 3 karakter.';
    if ($category === '') $errors[] = 'Kategori wajib diisi.';
    if (!is_numeric($price) || (float)$price <= 0) $errors[] = 'Harga harus lebih dari 0.';
    if (filter_var($stock, FILTER_VALIDATE_INT) === false || (int)$stock < 0) $errors[] = 'Stok harus 0 atau lebih.';

    if (empty($errors)) {
        $stmt = $pdo->prepare('SELECT id FROM products WHERE name = ? AND id != ? LIMIT 1');
        $stmt->execute([$name, $id]);
        if ($stmt->fetch()) $errors[] = 'Nama produk sudah digunakan oleh produk lain.';
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare('UPDATE products SET name = ?, category = ?, price = ?, stock = ? WHERE id = ?');
        $stmt->execute([$name, $category, $price, $stock, $id]);
        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - Azizah Diesel</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header class="app-header">
        <div class="header-container">
            <a href="index.php" class="brand-logo">
                <div class="logo-icon">⚙️</div>
                <div class="brand-text"><h1>Azizah Diesel</h1><span>Sistem Inventori Sparepart</span></div>
            </a>
            <a href="index.php" class="btn btn-secondary btn-sm">← Kembali ke Katalog</a>
        </div>
    </header>

    <main class="container">
        <div class="form-wrapper">
            <div class="form-card">
                <div class="form-header">
                    <div class="form-header-badge">✏️</div>
                    <h2>Edit Data Produk</h2>
                    <p>Ubah detail informasi produk <strong>#<?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8') ?></strong> di bawah ini.</p>
                </div>

                <?php if (!empty($errors)): ?>
                    <div class="alert-error">
                        <div class="alert-error-header"><span>⚠️</span> Periksa Kembali Inputan Anda:</div>
                        <ul><?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e, ENT_QUOTES, 'UTF-8') ?></li><?php endforeach; ?></ul>
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="form-group">
                        <label for="name">Nama Produk</label>
                        <div class="input-wrapper">
                            <span class="input-icon">📦</span>
                            <input type="text" id="name" name="name" class="form-control" value="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="category">Kategori Sparepart</label>
                        <div class="input-wrapper">
                            <span class="input-icon">🏷️</span>
                            <input type="text" id="category" name="category" class="form-control" value="<?= htmlspecialchars($category, ENT_QUOTES, 'UTF-8') ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="price">Harga Produk (Rp)</label>
                        <div class="input-wrapper">
                            <span class="input-icon">💰</span>
                            <input type="number" id="price" name="price" class="form-control" min="1" value="<?= htmlspecialchars($price, ENT_QUOTES, 'UTF-8') ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="stock">Jumlah Stok (Unit)</label>
                        <div class="input-wrapper">
                            <span class="input-icon">📊</span>
                            <input type="number" id="stock" name="stock" class="form-control" min="0" value="<?= htmlspecialchars($stock, ENT_QUOTES, 'UTF-8') ?>" required>
                        </div>
                    </div>
                    <div class="form-actions">
                        <a href="index.php" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>

        <footer class="app-footer">
            <p>&copy; <?= date('Y') ?> <strong>Azizah Diesel</strong>. Theme Baby Purple Edition.</p>
        </footer>
    </main>
</body>
</html>