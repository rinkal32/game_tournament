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
    die("Tournament ID not specified.");
}

/* -----------------------
   Fetch Tournament
------------------------ */
$tour = $conn->query("SELECT * FROM tournaments WHERE id=$tournament_id")->fetch_assoc();
if(!$tour){
    die("Tournament not found.");
}

/* -----------------------
   Check Join
------------------------ */
$joinCheck = $conn->query("SELECT * FROM tournament_players 
                           WHERE user_id=$user_id AND tournament_id=$tournament_id");

if($joinCheck->num_rows == 0){
    die("Join tournament before payment.");
}

/* -----------------------
   Prevent Double Payment
------------------------ */
$paidCheck = $conn->query("SELECT * FROM payments 
                           WHERE user_id=$user_id AND tournament_id=$tournament_id");

if($paidCheck->num_rows > 0){
    echo "<script>
    alert('Payment completed');
    </script>";
}

/* -----------------------
   Handle Payment
------------------------ */
if(isset($_POST['pay'])){
    $amount = $tour['entry_fee'];

    $conn->query("INSERT INTO payments 
        (user_id, tournament_id, amount, currency, payment_status, created_at)
        VALUES ($user_id, $tournament_id, $amount, 'INR', 'Paid', NOW())");

    $conn->query("UPDATE tournament_players 
        SET payment_status='Paid'
        WHERE user_id=$user_id AND tournament_id=$tournament_id");

    header("Location: player_dashboard.php?payment=success");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Payment - <?= htmlspecialchars($tour['title']) ?></title>
    <link rel="stylesheet" href="payment.css">

    <!-- Block back button -->
    <script>
        history.pushState(null, null, location.href);
        window.onpopstate = () => location.href="player_dashboard.php";
    </script>
</head>

<body>

<div class="payment-wrapper">

    <div class="payment-box">
        <h2>Payment</h2>

        <div class="info">
            <p><strong>Tournament:</strong> <?= htmlspecialchars($tour['title']) ?></p>
            <p><strong>Entry Fee:</strong> ₹<?= number_format($tour['entry_fee'],2) ?></p>
        </div>

        <form method="post">
            <label>Card Holder Name</label>
            <input type="text" required>

            <label>Card Number</label>
            <input type="text" maxlength="16" required>

            <div class="row">
                <div>
                    <label>Expiry</label>
                    <input type="month" required>
                </div>
                <div>
                    <label>CVV</label>
                    <input type="password" maxlength="3" required>
                </div>
            </div>

            <button type="submit" name="pay">
                Pay ₹<?= number_format($tour['entry_fee'],2) ?>
            </button>

            <small>* Demo payment – no real money deducted</small>
        </form>

        <a href="player_dashboard.php" class="cancel">
            ← Cancel & Go to Dashboard
        </a>
    </div>

</div>

</body>
</html>
