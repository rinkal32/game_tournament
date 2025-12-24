<?php
session_start();
include 'db.php';

/* LOGIN CHECK */
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

/* FETCH USER TOURNAMENTS */
$sql = "
SELECT 
    t.id,
    t.title,
    t.game_name,
    t.description,
    t.tournament_date,
    t.tournament_time,
    t.entry_fee,
    t.image,
    tp.payment_status
FROM tournament_players tp
JOIN tournaments t ON tp.tournament_id = t.id
WHERE tp.user_id = $user_id
ORDER BY t.tournament_date ASC
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Player Dashboard</title>
    <link rel="stylesheet" href="player_dashboard.css">
</head>

<body>

<div class="container">

    <div class="top-bar">
        <h1>Welcome, Player</h1>
        <div class="links">
            <a href="index.php">Home</a>
            <a href="find_tournament.php">Find Tournament</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <h2>My Tournaments</h2>

    <?php if($result->num_rows == 0): ?>
        <p class="empty">You have not joined any tournaments yet.</p>
    <?php else: ?>

    <div class="grid">

        <?php while($row = $result->fetch_assoc()): ?>

            <?php
            /* IMAGE FIX */
            $imagePath = "upload/default.jpg";
            if (!empty($row['image']) && file_exists("upload/".$row['image'])) {
                $imagePath = "upload/".$row['image'];
            }
            ?>

            <div class="card">

                <img src="<?= htmlspecialchars($imagePath) ?>" alt="Tournament Image">

                <div class="card-body">
                    <h3><?= htmlspecialchars($row['title']) ?></h3>
                    <span class="game"><?= htmlspecialchars($row['game_name']) ?></span>

                    <p class="desc">
                        <?= htmlspecialchars($row['description']) ?>
                    </p>

                    <p class="info">
                        📅 <?= htmlspecialchars($row['tournament_date']) ?><br>
                        ⏰ <?= htmlspecialchars($row['tournament_time']) ?><br>
                        💰 Entry Fee: ₹<?= htmlspecialchars($row['entry_fee']) ?>
                    </p>

                    <p class="status <?= $row['payment_status'] == 'Paid' ? 'paid' : 'pending' ?>">
                        Status: <?= htmlspecialchars($row['payment_status']) ?>
                    </p>

                    <?php if($row['payment_status'] == 'Pending'): ?>
                        <a class="pay-btn" href="payment.php?id=<?= $row['id'] ?>">
                            Pay Now
                        </a>
                    <?php endif; ?>
                </div>

            </div>

        <?php endwhile; ?>

    </div>
    <?php endif; ?>

</div>

</body>
</html>
