<?php
session_start();
include 'db.php';

$user_id = $_SESSION['user_id'];

$sql = "SELECT t.* FROM tournaments t
        JOIN tournament_players tp ON t.id = tp.tournament_id
        WHERE tp.user_id = $user_id";

$result = $conn->query($sql);

while($row = $result->fetch_assoc()){
    echo "<div>";
    echo "<h3>{$row['title']} ({$row['game_name']})</h3>";
    echo "<p>Entry Fee: {$row['entry_fee']} | Prize: {$row['prize']}</p>";
    echo "</div><hr>";
}
?>
