<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])) header("Location: login.php");

$uid = $_SESSION['user_id'];
$tid = (int)$_GET['id'];

// Confirm user joined and paid
$check = $conn->query("SELECT tp.*, t.title FROM tournament_players tp JOIN tournaments t ON tp.tournament_id=t.id WHERE tp.user_id=$uid AND tp.tournament_id=$tid AND tp.payment_status='Paid'");

if($check->num_rows == 0){
    die("❌ Payment not completed or tournament not joined");
}

$row = $check->fetch_assoc();
?>

<h2>🎉 Successfully Joined Tournament!</h2>
<p>Tournament: <?php echo $row['title']; ?></p>
<p>Payment Status: <?php echo $row['payment_status']; ?></p>

<a href="find_tournaments.php">Back to Tournaments</a>
<a href="my_tournaments.php">View My Tournaments</a>
