<?php

require_once 'auth.php';
    if (!$id_user=checkAuth()) {
        header('Location: login.php');
        exit;
    }


    if (!isset($_GET['q'])) {
        exit;
    }

header('Content-Type: application/json'); 
 
$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['pass'], $dbconfig['name']) or die(mysqli_error($conn)); 
$postId = mysqli_real_escape_string($conn, $_GET['q']); 
 
$query = "DELETE FROM post WHERE id = " . $postId . " AND author = '" . $_SESSION["user_id"] . "'"; 
 
if (mysqli_query($conn, $query)) $array[] = ['connectionSuccess' => true, 'deletedRows' => mysqli_affected_rows($conn)]; 
else $array[] = ['deleted' => false]; 
 
echo json_encode($array); 
mysqli_close($conn);

?>