<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

if(isset($_POST['pay'])){
    $user_id = $_SESSION['user_id'];
    $tournament_id = $_POST['tournament_id'];

    // Dummy payment success
    $payment_status = "SUCCESS";

    // Save payment record
    $sql = "INSERT INTO payments (user_id, tournament_id, status)
            VALUES ('$user_id', '$tournament_id', '$payment_status')";

    if($conn->query($sql)){
        // Redirect to dashboard
        header("Location: dashboard.php?payment=success");
        exit;
    } else {
        echo "Payment failed!";
    }
}
