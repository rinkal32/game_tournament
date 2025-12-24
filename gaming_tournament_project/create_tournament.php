<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit;
}

// Handle form submission
if(isset($_POST['create'])){
    $title = $conn->real_escape_string($_POST['title']);
    $game_name = $conn->real_escape_string($_POST['game_name']);
    $entry_fee = (int)$_POST['entry_fee'];
    $prize = $conn->real_escape_string($_POST['prize']);
    $status = 'Upcoming';
    $created_by = $_SESSION['user_id'];

    $sql = "INSERT INTO tournaments (title, game_name, entry_fee, prize, status, created_by) 
            VALUES ('$title', '$game_name', $entry_fee, '$prize', '$status', $created_by)";

    if($conn->query($sql)){
        // Popup and redirect
        echo "<script>
                alert('✅ Tournament created successfully!');
                window.location.href='dashboard.php';
              </script>";
        exit;
    } else {
        $error = $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Tournament</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        input, select { padding: 8px; margin: 5px 0; width: 300px; }
        button { padding: 10px 15px; background:#3399cc; color:white; border:none; border-radius:5px; cursor:pointer; }
    </style>
</head>
<body>
<h2>Create Tournament</h2>

<?php if(isset($error)) echo "<p style='color:red;'>Error: $error</p>"; ?>


<h2>Create Tournament</h2>

<form method="POST" action="save_tournament.php">

    <input type="text" name="title" placeholder="Tournament Title" required><br><br>
    <input type="text" name="game_name" placeholder="Game Name" required><br><br>
    <textarea name="description" placeholder="Tournament Description" required></textarea><br><br>
    <input type="date" name="tournament_date" required><br><br>
    <input type="time" name="tournament_time" required><br><br>
    <input type="number" name="entry_fee" placeholder="Entry Fee" required><br><br>
    <input type="number" name="prize" placeholder="Prize Amount" required><br><br>

    <button type="submit">Create Tournament</button>
</form>


<a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
