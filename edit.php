<?php
require 'connection.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: index.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM anime WHERE id = ?");
$stmt->execute([$id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    die("Data tidak ditemukan.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $judul   = $_POST['judul'];
    $type = $_POST['type'];
    $genre   = $_POST['genre'];
    $studio  = $_POST['studio'];
    $rating  = $_POST['rating'];
    $status  = $_POST['status'];
    $episode = $_POST['episode'];

    $sql = "UPDATE anime 
            SET judul = ?, type = ?, genre = ?, studio = ?, rating = ?, status = ?, episode = ?
            WHERE id = ?";

    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$judul, $type, $genre, $studio, $rating, $status, $episode, $id])) {
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Anime</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="navbar">
    MiniAnimeList
</header>

<div class="form-wrapper">
    <div class="card">

        <h2>Edit Anime</h2>

        <form method="POST">

            <label>Judul</label>
            <input type="text" name="judul"
                value="<?= htmlspecialchars($data['judul']); ?>" required>

            <label>Type</label>
            <select name="type" required>
                <option value="TV Series" <?= $data['type']=='TV Series'?'selected':''; ?>>TV Series</option>
                <option value="Movie" <?= $data['type']=='Movie'?'selected':''; ?>>Movie</option>
                <option value="OVA" <?= $data['type']=='OVA'?'selected':''; ?>>OVA</option>
                <option value="ONA" <?= $data['type']=='ONA'?'selected':''; ?>>ONA</option>
                <option value="Special" <?= $data['type']=='Special'?'selected':''; ?>>Special</option>
            </select>

            <label>Genre</label>
            <input type="text" name="genre"
                value="<?= htmlspecialchars($data['genre']); ?>" required>

            <label>Studio</label>
            <input type="text" name="studio"
                value="<?= htmlspecialchars($data['studio']); ?>">

            <label>Episode</label>
            <input type="number" name="episode"
                value="<?= htmlspecialchars($data['episode']); ?>">

            <label>Rating</label>
            <input type="number" name="rating" min="0" max="10" step="0.1"
                value="<?= htmlspecialchars($data['rating']); ?>" required>

            <label>Status</label>
            <select name="status">
                <option value="Watching" <?= $data['status']=='Watching'?'selected':''; ?>>Watching</option>
                <option value="Completed" <?= $data['status']=='Completed'?'selected':''; ?>>Completed</option>
                <option value="Plan to Watch" <?= $data['status']=='Plan to Watch'?'selected':''; ?>>Plan to Watch</option>
                <option value="Dropped" <?= $data['status']=='Dropped'?'selected':''; ?>>Dropped</option>
            </select>

            <button type="submit">Update</button>

        </form>

    </div>
</div>

</body>
</html>