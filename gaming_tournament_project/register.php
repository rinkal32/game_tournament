<?php
include 'db.php';

if(isset($_POST['register'])){

    $name  = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // ✅ Check if email already exists
    $check = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");
    if(mysqli_num_rows($check) > 0){
        echo "<script>alert('Email already exists! Please login.');</script>";
    } else {

        // ✅ Insert only if email does NOT exist
        mysqli_query($conn, "INSERT INTO users(name,email,password) 
                             VALUES('$name','$email','$password')");

        // ✅ Redirect to login page
        header("Location: login.php?registered=1");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="register.css">
</head>
<body>

<form method="post">
    <div class="form">
        <h1>R e g i s t e r</h1>

        <input type="text" name="name" placeholder="✍️ Name" required><br>
        <input type="email" name="email" placeholder="📩 Email" required><br>
        <input type="password" name="password" placeholder="🔑 Password" required><br>

        <button type="submit" name="register">R e g i s t e r</button><br>

        <p>Already have an account?
            <a href="login.php">Click Here!</a>
        </p>
    </div>
</form>

</body>
</html>
