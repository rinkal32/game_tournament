<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/admin_dashboard.css">
</head>
<body>

<div class="dashboard">

    <!-- Sidebar -->
    <aside class="sidebar">
        <h2 class="logo">🎮 Admin Panel</h2>
        <ul>
            <li><a href="admin_user.php">👥 Manage Users</a></li>
            <li><a href="admin_tournament.php">🏆 Create Tournaments</a></li>
            <li><a href="admin_payment.php">⚔️ Manage Payment</a></li>
            <li class="logout"><a href="logout.php">🚪 Logout</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="content">
        <div class="header">
            <h1>Welcome, <?php echo $_SESSION['admin_username'] ?? 'Admin'; ?> 👋</h1>
            <p><?php echo $_SESSION['admin_email'] ?? ''; ?></p>
        </div>

        <div class="cards">
            <div class="card">
                <h3>Users</h3>
                <p>Manage registered players</p>
            </div>

            <div class="card">
                <h3>Tournaments</h3>
                <p>Create & view tournaments</p>
            </div>

            <div class="card">
                <h3>Matches</h3>
                <p>Schedule & manage matches</p>
            </div>
        </div>
    </main>

</div>

</body>
</html>
