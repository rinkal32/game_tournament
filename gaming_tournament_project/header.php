<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Battle</title>
    <link rel="stylesheet" href="header.Css">
</head>
<body>
    <header> 
        <nav> 
            <h1 id="logo">Dynamic Battle</h1>
            <ul>
                <li><a href="index.php">Home</a> </li>
                <li><a href="player_dashboard.php">Tournaments</a> </li>
                 
            </ul>
                
            <div> 
                <?php if(!isset($_SESSION['user_id'])){ ?> 
                    <a href="login.php" class="btn">Login</a> 
                   
                     <?php }
                     else{ ?> <a href="profile.php" class="profile">👤</a> 
                       
                        <?php } ?> 
                    </div> 
                </nav> 
            </header>

    </div>
</header>
</body>
</html>

