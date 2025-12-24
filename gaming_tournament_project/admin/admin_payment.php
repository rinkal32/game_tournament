<?php
session_start();
include 'db.php';
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){ 
    echo " <script> alert('Access Denied! Admins only.'); 
    window.history.back(); </script> "; 
    exit; 
}
/* Admin access check */
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

/* Fetch all payments (pending + paid) */
$query = "
SELECT 
    payments.id,
    users.name AS player_name,
    tournaments.title AS tournament_name,
    payments.amount,
    payments.payment_status,
    payments.created_at
FROM payments
LEFT JOIN users ON payments.user_id = users.id
LEFT JOIN tournaments ON payments.tournament_id = tournaments.id
ORDER BY payments.created_at DESC
";

$res = mysqli_query($conn, $query);

if (!$res) {
    die('Query Error: ' . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Payments</title>
    <link rel="stylesheet" href="css/admin_payment.css">
</head>
<body>

<div class="container">
<h2>💰 Payment Records</h2>

<table>
<tr>
    <th>Player</th>
    <th>Tournament</th>
    <th>Amount</th>
    <th>Status</th>
    <th>Date</th>
</tr>

<?php
if (mysqli_num_rows($res) > 0) {

    while ($row = mysqli_fetch_assoc($res)) {

        $status = strtolower(trim($row['payment_status']));
        $class  = ($status === 'paid' || $status === 'success')
                    ? 'status-paid'
                    : 'status-pending';

        echo "
        <tr>
            <td>{$row['player_name']}</td>
            <td>{$row['tournament_name']}</td>
            <td>₹{$row['amount']}</td>
            <td><span class='{$class}'>{$row['payment_status']}</span></td>
            <td>{$row['created_at']}</td>
        </tr>";
    }

} else {
    echo "<tr><td colspan='5'>No Payments Found</td></tr>";
}
?>

</table>
</div>
</body>
</html>
