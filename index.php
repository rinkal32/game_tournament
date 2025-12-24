<?php include 'header.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Gaming Tournament Hub</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<section class="banner">
    <h1 class="title">Join the Battle, Win <br> the Glory!</h1>
    <p class="txt">Compete in Exciting Gaming Tournaments</p>

    <div class="banner-buttons">
        <a href="find_tournament.php" class="btn btn-primary">Find Tournaments</a>
       <!-- <a href="admin/admin_tournament.php" class="btn btn-success">Create Tournament</a>!-->
    </div>
</section>

<section class="features">
    <div class="feature-card">
        <h3>Player Dashboard</h3>
        <p>Manage your profile & teams</p>
        <a href="player_dashboard.php" class="btn">Go to Dashboard</a>
    </div>

    <div class="feature-card">
        <h3>Payment Center</h3>
        <p>View & manage payments</p>
        <a href="admin/admin_payment.php" class="btn">Payment Portal</a>
    </div>

    <div class="feature-card">
        <h3>Admin Panel</h3>
        <p>Admin controls & reports</p>
        <a href="admin/admin_dashboard.php" class="btn">Admin Access</a>
    </div>
</section>
<section class="contact-section">
    <h2>Contact Us</h2>
    <p class="contact-text">
        Have questions or need support? Send us a message.
    </p>

    <form class="contact-form" action="contact_submit.php" method="post">
    <div class="form-row">
        <input type="text" name="name" placeholder="Your Name" required>
        <input type="email" name="email" placeholder="Your Email" required>
    </div>

    <div class="form-row">
        <input type="tel" name="mobile" placeholder="Mobile Number"
               pattern="[6-9]{1}[0-9]{9}" required>
    </div>

    <textarea name="message" placeholder="Your Message" required></textarea>

    <button type="submit" name="send">Send Message</button>
</form>
    <?php if(isset($_GET['success'])){ ?>
    <div class="success-msg">✅ Message sent successfully!</div>
<?php } ?>

<?php if(isset($_GET['error'])){ ?>
    <div class="error-msg">❌ Something went wrong!</div>
<?php } ?>

</section>

<footer>
    <p>© 2025 Gaming Tournament Hub. All Rights Reserved.</p>
</footer>

</body>
</html>
