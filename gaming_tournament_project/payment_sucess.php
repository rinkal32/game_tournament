<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Get tournament ID
$tournament_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if($tournament_id <= 0) die("Tournament ID not specified");

// Get tournament info
$tour = $conn->query("SELECT * FROM tournaments WHERE id=$tournament_id")->fetch_assoc();
if(!$tour) die("Tournament not found");

// Ensure tournament_players and payments updated
$conn->query("UPDATE tournament_players 
              SET payment_status='Paid' 
              WHERE user_id=$user_id AND tournament_id=$tournament_id");

$check_payment = $conn->query("SELECT * FROM payments WHERE user_id=$user_id AND tournament_id=$tournament_id AND payment_status='Paid'");
if($check_payment->num_rows == 0){
    $amount = $tour['entry_fee'];
    $conn->query("INSERT INTO payments (user_id, tournament_id, amount, payment_status) 
                  VALUES ($user_id, $tournament_id, $amount, 'Paid')");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment Success</title>
</head>
<body>
<h2>Payment Successful!</h2>
<p>You have successfully paid ₹<?= $tour['entry_fee'] ?> for the tournament: <strong><?= htmlspecialchars($tour['title']) ?></strong></p>

<a href="player_dashboard.php">Go to Dashboard</a>
<a href="find_tournament.php">Find Other Tournaments</a>
</body>
</html>
