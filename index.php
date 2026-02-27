<?php
require 'connection.php';

$stmt = $pdo->query("SELECT * FROM anime ORDER BY rating DESC");
$anime = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>MyAnimeList</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header class="navbar">
        MiniAnimeList
    </header>

    <div class="container">

        <a href="tambah.php" class="card add-card">
            <div class="plus">+</div>
            Tambah Anime
        </a>

        <?php foreach($anime as $row): ?>
            <div class="card">
                <h3><?= htmlspecialchars($row['judul']); ?></h3>
                <p class="type"><?= htmlspecialchars($row['type']); ?></p>
                <p><?= htmlspecialchars($row['genre']); ?></p>
                <p><?= htmlspecialchars($row['studio']); ?></p>
                <p class="rating">★ <?= htmlspecialchars($row['rating']); ?></p>

                <span class="badge <?= strtolower(str_replace(' ', '-', $row['status'])); ?>">
                    <?= htmlspecialchars($row['status']); ?>
                <p class="episode">Episode: <?= htmlspecialchars($row['episode']); ?></p>
                </span>

                <div class="actions">
                    <a href="edit.php?id=<?= $row['id']; ?>">Edit</a>
                    <a href="hapus.php?id=<?= $row['id']; ?>" onclick="return confirm('Yakin?')">
                        Delete
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</body>
</html>