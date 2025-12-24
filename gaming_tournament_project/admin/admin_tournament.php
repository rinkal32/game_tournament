<?php
session_start();
include 'db.php';

/* NOT LOGGED IN */
if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit;
}

/* NOT ADMIN */
if ($_SESSION['role'] !== 'admin') {
    echo "<script>
            alert('❌ Only admin can create tournaments');
            window.history.back();
          </script>";
    exit;
}

/* HANDLE FORM SUBMISSION */
if(isset($_POST['create'])){

    $title = $conn->real_escape_string($_POST['title']);
    $game_name = $conn->real_escape_string($_POST['game_name']);
    $description = $conn->real_escape_string($_POST['description']);
    $tournament_date = $_POST['tournament_date'];
    $tournament_time = $_POST['tournament_time'];
    $entry_fee = (int)$_POST['entry_fee'];
    $prize = (int)$_POST['prize'];
    $status = 'Upcoming';
    $created_by = $_SESSION['user_id'];

    /* IMAGE UPLOAD */
    $imageName = "";

    if (!empty($_FILES['image']['name'])) {

        $img_name = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];

        $img_ext = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','webp'];

        if(!in_array($img_ext, $allowed)){
            die("Only JPG, PNG, WEBP images allowed");
        }

        if ($_FILES['image']['size'] > 2*1024*1024) {
            die("Image must be less than 2MB");
        }

        $imageName = time().'_'.$img_name;

        move_uploaded_file(
            $tmp_name,
            "../upload/".$imageName
        );
    }

    /* INSERT INTO DATABASE */
    $sql = "INSERT INTO tournaments 
    (title, game_name, description, tournament_date, tournament_time, entry_fee, prize, image, status, created_by)
    VALUES 
    ('$title','$game_name','$description','$tournament_date','$tournament_time',$entry_fee,$prize,'$imageName','$status',$created_by)";

    if($conn->query($sql)){
        echo "<script>
                alert('✅ Tournament created successfully!');
                window.location.href='../index.php';
              </script>";
        exit;
    } else {
        echo "Error: ".$conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Tournament</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/tournament.css">
    <style>
        body { font-family: Arial; padding: 20px; }
        input, textarea { padding: 8px; margin: 5px 0; width: 300px; }
        button { padding: 10px 15px; background:#3399cc; color:white; border:none; border-radius:5px; cursor:pointer; }
    </style>
</head>
<body>

<div class="wrapper">
    <div class="card">

        <!-- FORM SECTION -->
        <div class="form-section">
            <h2>🎮 Create Tournament</h2>

            <form method="POST" enctype="multipart/form-data">

                <input type="text" name="title" placeholder="Tournament Title" required>

                <input type="text" name="game_name" placeholder="Game Name" required>

                <textarea name="description" placeholder="Tournament Description" required></textarea>

                <input type="date" name="tournament_date" required>

                <input type="time" name="tournament_time" required>

                <input type="number" name="entry_fee" placeholder="Entry Fee" required>

                <input type="number" name="prize" placeholder="Prize Amount" required>

                <div class="file-box">
                    Upload Tournament Banner<br><br>
                    <input type="file" name="image" accept="image/*" required>
                </div>

                <button type="submit" name="create">Create Tournament</button>
            </form>

            <a href="dashboard.php" class="back">← Back to Dashboard</a>
        </div>

        <!-- IMAGE SECTION -->
        <div class="banner">
            <h1>Compete.<br>Win.<br>Dominate.</h1>
        </div>

    </div>
</div>


</body>
</html>
