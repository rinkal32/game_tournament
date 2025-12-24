<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}
?>

<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'] ?? 'player';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top:20px;}
        th, td { border: 1px solid #ccc; padding: 10px; text-align:left;}
        th { background: #f0f0f0; }
        .btn { padding: 8px 12px; background:#3399cc; color:white; text-decoration:none; border-radius:5px; }
    </style>
</head>
<body>

<h2>Dashboard</h2>

<?php if($role=='admin'): ?>
    <a href="create_tournament.php" class="btn">Create Tournament</a>
<?php endif; ?>

<h3>My Tournaments</h3>

<?php
// Admin sees all tournaments they created
if($role=='admin'){
    $sql = "SELECT * FROM tournaments WHERE created_by=$user_id ORDER BY id DESC";
} else {
    // Player sees joined tournaments
    $sql = "SELECT t.*, tp.payment_status 
            FROM tournaments t 
            JOIN tournament_players tp ON t.id=tp.tournament_id 
            WHERE tp.user_id=$user_id
            ORDER BY t.id DESC";
}

$result = $conn->query($sql);

if($result->num_rows > 0){
    echo "<table>
            <tr>
                <th>Title</th>
                <th>Game</th>
                <th>Entry Fee</th>
                <th>Prize</th>
                <th>Status</th>";
    if($role=='player') echo "<th>Payment Status</th>";
    echo "</tr>";

    while($row = $result->fetch_assoc()){
        echo "<tr>
                <td>".htmlspecialchars($row['title'])."</td>
                <td>".htmlspecialchars($row['game_name'])."</td>
                <td>₹".$row['entry_fee']."</td>
                <td>".htmlspecialchars($row['prize'])."</td>
                <td>".htmlspecialchars($row['status'])."</td>";
        if($role=='player') echo "<td>".htmlspecialchars($row['payment_status'])."</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p>No tournaments found.</p>";
}
?>
<?php
if(isset($_GET['payment']) && $_GET['payment'] == 'success'){
    echo "<p style='color:green;'>✅ Payment Successful!</p>";
}
?>

<a href="find_tournament.php" class="btn">Find Tournaments</a>
<a href="logout.php" class="btn" style="background:red;">Logout</a>

</body>
</html>
