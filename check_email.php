<?php 
require_once 'dbconfig.php'; 
 
 
// EMAIL CHECK 
 
if (isset($_GET["q"])) { 
 
    header('Content-Type: application/json'); 
 
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['pass'], $dbconfig['name']); 
    $email = mysqli_real_escape_string($conn, $_GET["q"]); 
    $query = "SELECT email FROM users WHERE email = '" . $email . "'"; 
    $res = mysqli_query($conn, $query) or die(mysqli_error($conn)); 
 
    echo json_encode(array('exists' => mysqli_num_rows($res) > 0 ? true : false)); 
    mysqli_close($conn); 
 
    exit; 
}