<?php
require 'connection.php';

$stmt = $pdo->query("SELECT * FROM anime ORDER BY rating DESC");
$anime = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MiniAnimeList</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Bebas+Neue&display=swap" rel="stylesheet">
</head>
<body>

    <!-- NAVBAR -->
    <header class="navbar">
        <div class="navbar-inner">
            <div class="navbar-brand">
                <span class="brand-icon">▶</span>
                <span class="brand-text">Mini<strong>AnimeList</strong></span>
            </div>
            <nav class="navbar-links">
                <a href="#">Anime</a>
                <a href="#">Manga</a>
                <a href="#">Top</a>
                <a href="#">Seasonal</a>
            </nav>
            <div class="navbar-right">
                <a href="tambah.php" class="btn-add-nav">+ Add Anime</a>
            </div>
        </div>
    </header>

    <!-- HERO STRIP -->
    <div class="hero-strip">
        <div class="hero-inner">
            <span class="hero-label">MY LIST</span>
            <h1 class="hero-title">Anime Collection</h1>
            <div class="hero-stats">
                <div class="stat-item">
                    <span class="stat-number"><?= count($anime); ?></span>
                    <span class="stat-label">Total Anime</span>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <span class="stat-number"><?= count(array_filter($anime, fn($a) => $a['status'] === 'Watching')); ?></span>
                    <span class="stat-label">Watching</span>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <span class="stat-number"><?= count(array_filter($anime, fn($a) => $a['status'] === 'Completed')); ?></span>
                    <span class="stat-label">Completed</span>
                </div>
            </div>
        </div>
    </div>

    <!-- FILTER BAR -->
    <div class="filter-bar">
        <div class="filter-inner">
            <span class="filter-label">Sort by:</span>
            <button class="filter-btn active">Rating</button>
            <button class="filter-btn">Title</button>
            <button class="filter-btn">Status</button>
            <button class="filter-btn">Type</button>
        </div>
    </div>

    <!-- ANIME GRID -->
    <main class="main-content">
        <div class="container">

            <!-- ADD CARD -->
            <a href="tambah.php" class="card add-card">
                <div class="add-icon">+</div>
                <span class="add-label">Add New Anime</span>
            </a>

            <!-- ANIME CARDS -->
            <?php foreach($anime as $index => $row): ?>
                <div class="card anime-card" style="animation-delay: <?= $index * 0.05 ?>s">

                    <!-- Rank Badge -->
                    <div class="rank-badge">#<?= $index + 1 ?></div>

                    <!-- Card Header -->
                    <div class="card-header">
                        <div class="card-type-tag"><?= htmlspecialchars($row['type']); ?></div>
                        <div class="card-status-dot <?= strtolower(str_replace(' ', '-', $row['status'])); ?>"></div>
                    </div>

                    <!-- Title -->
                    <h3 class="card-title"><?= htmlspecialchars($row['judul']); ?></h3>

                    <!-- Meta info -->
                    <div class="card-meta">
                        <span class="meta-item studio-icon"><?= htmlspecialchars($row['studio']); ?></span>
                        <span class="meta-item genre-tag"><?= htmlspecialchars($row['genre']); ?></span>
                    </div>

                    <!-- Divider -->
                    <div class="card-divider"></div>

                    <!-- Rating + Episode Row -->
                    <div class="card-bottom">
                        <div class="rating-block">
                            <span class="star">★</span>
                            <span class="rating-score"><?= htmlspecialchars($row['rating']); ?></span>
                            <span class="rating-max">/10</span>
                        </div>
                        <div class="episode-block">
                            <span class="ep-count"><?= htmlspecialchars($row['episode']); ?></span>
                            <span class="ep-label">eps</span>
                        </div>
                    </div>

                    <!-- Status Badge -->
                    <div class="status-badge <?= strtolower(str_replace(' ', '-', $row['status'])); ?>">
                        <?= htmlspecialchars($row['status']); ?>
                    </div>

                    <!-- Actions -->
                    <div class="actions">
                        <a href="edit.php?id=<?= $row['id']; ?>" class="btn-edit">✎ Edit</a>
                        <a href="hapus.php?id=<?= $row['id']; ?>" class="btn-delete" onclick="return confirm('Hapus anime ini?')">✕ Delete</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer class="site-footer">
        <p>MiniAnimeList &copy; <?= date('Y') ?> — Inspired by <a href="https://myanimelist.net" target="_blank">MyAnimeList</a></p>
    </footer>

</body>
</html>