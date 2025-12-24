<?php
session_start();
include 'db.php';

if(isset($_POST['login'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result) == 1){

        $user = mysqli_fetch_assoc($result);

        if(password_verify($password, $user['password'])){

            /* 🔴 CLEAR ADMIN SESSION (IMPORTANT) */
            unset($_SESSION['admin_id']);
            unset($_SESSION['admin_email']);
            unset($_SESSION['role']);

            /* ✅ SET USER SESSION ONLY */
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            header("Location: index.php");
            exit;

        } else {
            $error = "Wrong password";
        }

    } else {
        $error = "User not found";
    }
}
?>

<?php
if(isset($_GET['registered'])){
    echo "<p style='color:green'>Registration successful. Please login.</p>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<link rel="stylesheet" href="login.css">
</head>
<body>

<h2>Login</h2>

<?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>

<form method="POST">
    <div class="form">
        <h1>L o g i n</h1>
        <input type="email" name="email" placeholder="📩 Email" required><br><br>
        <input type="password" name="password" placeholder="🔑 Password" required><br><br>
        <button name="login">L o g i n</button>
        <p>Don't have an account? <a href="register.php">Click Here!</a></p>
    </div>
</form>

</body>
</html>
