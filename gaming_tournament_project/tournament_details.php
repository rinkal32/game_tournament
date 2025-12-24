<?php
session_start();
include 'db.php';

if(!isset($_GET['id'])){
    die("Invalid Tournament");
}

$id = (int)$_GET['id'];
$t = $conn->query("SELECT * FROM tournaments WHERE id = $id")->fetch_assoc();

if(!$t){
    die("Tournament not found");
}

echo "<h2>{$t['title']}</h2>
<p>Game: {$t['game_name']}</p>
<p>Entry Fee: {$t['entry_fee']}</p>
<p>Status: {$t['status']}</p>";

if(isset($_SESSION['user_id'])){
    echo "<a href='join_tournament.php?id=".$t['id']."'>
            Join Tournament
          </a>";
} else {
    echo "<p>Please <a href='login.php'>login</a> to join this tournament.</p>";
}
?>
