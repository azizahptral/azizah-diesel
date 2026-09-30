<?php
session_start();
require_once 'config/database.php';

if (empty($_SESSION['csrf_token'])) $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

$products = $pdo->query('SELECT id, name, category, price, stock FROM products ORDER BY id DESC')->fetchAll();
$totalProducts = count($products);
$totalStock = array_sum(array_column($products, 'stock'));
$categories = array_values(array_unique(array_filter(array_column($products, 'category'))));
$totalCategories = count($categories);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Azizah Diesel - Katalog & Inventori Produk</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header class="app-header">
        <div class="header-container">
            <a href="index.php" class="brand-logo">
                <div class="logo-icon">⚙️</div>
                <div class="brand-text">
                    <h1>Azizah Diesel</h1>
                    <span>Sistem Inventori Sparepart</span>
                </div>
            </a>
            <a href="create.php" class="btn btn-primary">+ Tambah Produk Baru</a>
        </div>
    </header>

    <main class="container">
        <div class="hero-banner">
            <div class="hero-header">
                <div class="hero-title">
                    <h2>Manajemen Stok & Produk</h2>
                    <p>Kelola katalog produk, harga, dan ketersediaan stok Azizah Diesel secara real-time.</p>
                </div>
            </div>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">📦</div>
                    <div class="stat-info"><div class="stat-value"><?= number_format($totalProducts) ?></div><div class="stat-label">Total Jenis Produk</div></div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">🏷️</div>
                    <div class="stat-info"><div class="stat-value"><?= number_format($totalCategories) ?></div><div class="stat-label">Kategori Terdaftar</div></div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">📊</div>
                    <div class="stat-info"><div class="stat-value"><?= number_format($totalStock) ?></div><div class="stat-label">Total Unit Stok</div></div>
                </div>
            </div>
        </div>

        <div class="toolbar">
            <div class="search-box">
                <span class="search-icon">🔍</span>
                <input type="text" id="searchInput" placeholder="Cari nama produk atau kategori..." onkeyup="filterProducts()">
            </div>
            <?php if (!empty($categories)): ?>
            <div class="filter-pills" id="categoryFilter">
                <button class="filter-pill active" onclick="setCategoryFilter('all', this)">Semua Kategori</button>
                <?php foreach ($categories as $cat): ?>
                    <button class="filter-pill" onclick="setCategoryFilter('<?= htmlspecialchars($cat, ENT_QUOTES, 'UTF-8') ?>', this)"><?= htmlspecialchars($cat, ENT_QUOTES, 'UTF-8') ?></button>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>

        <div class="product-grid" id="productGrid">
            <?php if (empty($products)): ?>
                <div class="empty-state">
                    <div class="empty-icon">📂</div>
                    <h3>Belum ada produk terdaftar</h3>
                    <p>Mulai tambahkan item produk sparepart diesel pertama Anda ke dalam sistem.</p>
                    <a href="create.php" class="btn btn-primary">+ Tambah Produk Pertama</a>
                </div>
            <?php else: ?>
                <?php foreach ($products as $p):
                    $stk = (int)$p['stock'];
                    [$sClass, $sLabel] = $stk <= 0 ? ['out-of-stock', '⚠️ Stok Habis (0)'] : ($stk <= 5 ? ['low-stock', "⚡ Stok Menipis ($stk)"] : ['in-stock', "✓ Stok Ready ($stk)"]);
                ?>
                    <div class="product-card" data-name="<?= strtolower(htmlspecialchars($p['name'], ENT_QUOTES, 'UTF-8')) ?>" data-category="<?= strtolower(htmlspecialchars($p['category'], ENT_QUOTES, 'UTF-8')) ?>">
                        <div>
                            <div class="card-top">
                                <span class="category-badge">🏷️ <?= htmlspecialchars($p['category'], ENT_QUOTES, 'UTF-8') ?></span>
                                <span class="stock-badge <?= $sClass ?>"><?= $sLabel ?></span>
                            </div>
                            <h2 class="product-title"><?= htmlspecialchars($p['name'], ENT_QUOTES, 'UTF-8') ?></h2>
                            <div class="price-tag">
                                <span class="price-currency">Rp</span>
                                <span class="price-amount"><?= number_format((float)$p['price'], 0, ',', '.') ?></span>
                            </div>
                        </div>
                        <div class="card-actions">
                            <a href="edit.php?id=<?= $p['id'] ?>" class="btn btn-secondary btn-sm">✏️ Edit</a>
                            <form method="POST" action="delete.php" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk <?= htmlspecialchars(addslashes($p['name']), ENT_QUOTES, 'UTF-8') ?>?');">
                                <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
                                <button type="submit" class="btn btn-danger btn-sm">🗑️ Hapus</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <footer class="app-footer">
            <p>&copy; <?= date('Y') ?> <strong>Azizah Diesel</strong>. Theme Baby Purple Edition.</p>
        </footer>
    </main>

    <script>
        let currentCategory = 'all';
        function filterProducts() {
            const q = document.getElementById('searchInput').value.toLowerCase().trim();
            document.querySelectorAll('.product-card').forEach(card => {
                const name = card.getAttribute('data-name'), cat = card.getAttribute('data-category');
                card.style.display = (name.includes(q) || cat.includes(q)) && (currentCategory === 'all' || cat === currentCategory.toLowerCase()) ? 'flex' : 'none';
            });
        }
        function setCategoryFilter(cat, btn) {
            currentCategory = cat;
            document.querySelectorAll('.filter-pill').forEach(p => p.classList.remove('active'));
            if (btn) btn.classList.add('active');
            filterProducts();
        }
    </script>
</body>
</html>