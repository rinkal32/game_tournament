<?php
$conn = new mysqli("localhost","root","","gaming_tour_website");
if($conn->connect_error){
    die("Database Connection Failed");
}
?>
