<?php
session_start();
include 'db.php';

/* -----------------------
   Login Check
------------------------ */
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

/* -----------------------
   Tournament ID Check
------------------------ */
$tournament_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if($tournament_id <= 0){
    echo "<script>
        alert('Please go back and select a tournament');
        window.history.back();
    </script>";
    exit;
}

/* -----------------------
   Check Tournament Exists
------------------------ */
$tourCheck = $conn->query("SELECT id FROM tournaments WHERE id=$tournament_id");
if($tourCheck->num_rows == 0){
    echo "<script>
        alert('This tournament is not available');
        window.history.back();
    </script>";
    exit;
}

/* -----------------------
   Check if Already Joined
------------------------ */
$check = $conn->query("SELECT * FROM tournament_players 
                       WHERE user_id=$user_id AND tournament_id=$tournament_id");

if($check->num_rows > 0){
    // Already joined → go to payment
    header("Location: payment.php?id=$tournament_id");
    exit;
}

/* -----------------------
   Join Tournament (Pending Payment)
------------------------ */
$conn->query("INSERT INTO tournament_players 
(user_id, tournament_id, payment_status) 
VALUES 
($user_id, $tournament_id, 'Pending')");

/* -----------------------
   Redirect to Payment
------------------------ */
header("Location: payment.php?id=$tournament_id");
exit;
