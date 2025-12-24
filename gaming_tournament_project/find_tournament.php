<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM tournaments 
        WHERE id NOT IN (
            SELECT tournament_id FROM tournament_players WHERE user_id=$user_id
        )";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Find Tournaments</title>
    <link rel="stylesheet" href="find_tournament.Css">
</head>
<body>

<h2 class="page-title">Available Tournaments</h2>

<div class="tournament-container">

<?php if($result->num_rows > 0): ?>
<?php while($row = $result->fetch_assoc()): ?>

<div class="tournament-card">

<div class="card-left">
<?php
$imagePath = "upload/default.jpg"; // fallback

if (!empty($row['image'])) {

    $fileName = trim($row['image']);
    $fullPath = __DIR__ . "/upload/" . $fileName; // absolute path check

    if (file_exists($fullPath)) {
        $imagePath = "upload/" . $fileName; // browser path
    }
}
?>
<img src="<?= htmlspecialchars($imagePath) ?>" alt="Tournament Image">
</div>





    <div class="card-right">
        <h3>
            <?= htmlspecialchars($row['title']) ?> 
            <span>(<?= htmlspecialchars($row['game_name']) ?>)</span>
        </h3>

        <p class="desc"><?= htmlspecialchars($row['description']) ?></p>

        <p class="datetime">
            <strong>Date:</strong> <?= htmlspecialchars($row['tournament_date']) ?> |
            <strong>Time:</strong> <?= htmlspecialchars($row['tournament_time']) ?>
        </p>

        <p class="price">
            Entry Fee: <span>₹<?= htmlspecialchars($row['entry_fee']) ?></span> |
            Prize: <span class="prize">₹<?= htmlspecialchars($row['prize']) ?></span>
        </p>

        <a href="join_tournament.php?id=<?= $row['id'] ?>" class="join-btn">
            Join Tournament
        </a>
    </div>

</div>

<?php endwhile; ?>
<?php else: ?>
<p class="no-data">No tournaments available at the moment.</p>
<?php endif; ?>

</div>

<a href="player_dashboard.php" class="back-link">← Back to Dashboard</a>

</body>
</html>
