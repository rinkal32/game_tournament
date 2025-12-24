<?php
include 'db.php';

if(isset($_POST['send'])){

    $name    = mysqli_real_escape_string($conn, $_POST['name']);
    $email   = mysqli_real_escape_string($conn, $_POST['email']);
    $mobile  = mysqli_real_escape_string($conn, $_POST['mobile']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $query = "INSERT INTO contact_messages (name, email, mobile, message)
              VALUES ('$name', '$email', '$mobile', '$message')";
    

    if(mysqli_query($conn, $query)){
        // Redirect after successful insert
        header("Location: index.php?success=1");
        exit;
    } else {
        header("Location: index.php?error=1");
        exit;
    }
}
?>



