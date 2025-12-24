<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$id = $_SESSION['user_id'];
$result = mysqli_query($conn,"SELECT * FROM users WHERE id=$id");
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Profile</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- External CSS -->
    <link rel="stylesheet" href="profile.css">
</head>

<body>

<div class="profile-wrapper">
    <div class="profile-card">

        <h2 class="title">🎮 My Profile</h2>

        <!-- Avatar -->
        <div class="avatar">
            <?php echo strtoupper(substr($user['name'],0,1)); ?>
        </div>

        <!-- Info -->
        <div class="info">
            <p><span>Username</span><?php echo $user['name']; ?></p>
            <p><span>Email</span><?php echo $user['email']; ?></p>
        </div>

        <!-- Buttons -->
        <div class="actions">
            <a href="logout.php" class="btn logout">Logout</a>
        </div>

    </div>
</div>

</body>
</html>
