<?php
 require_once 'auth.php'; 
 if (!checkAuth()) {
     echo 'auth error';
     exit;
 }

$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['pass'], $dbconfig['name']); 
 

if (isset($_GET["posts"])) { 
    if ($_GET["posts"] == "all") { 
 
        $query = "SELECT post.id,username,title,contenuto FROM post JOIN users u ON u.id=post.author ORDER BY post.id DESC"; 
        $res = mysqli_query($conn, $query); 
 
        while ($row = mysqli_fetch_assoc($res)) { 
            $posts[] = ["id_post" => $row["id"], "author" => $row["username"], "content" => array("title" => $row["title"], "caption" => $row["contenuto"])]; 
        } 
 
        if (!empty($posts)) echo json_encode($posts); 
            else echo 0; 
    } 
        else if ($_GET["posts"] == "mine") { 
         
        $query = "SELECT post.id,username,title,contenuto FROM post JOIN users u ON u.id=post.author WHERE u.id = ".$_SESSION["user_id"]; 
        $res = mysqli_query($conn, $query); 
 
        while ($row = mysqli_fetch_assoc($res)) { 
            $posts[] = ["id_post" => $row["id"], "author" => $row["username"], "content" => array("title" => $row["title"], "caption" => $row["contenuto"])]; 
        } 
 
        if (!empty($posts)) echo json_encode($posts); 
        else echo 0;
    } 
}

if (isset($_GET["search"])) { 
    $searchQuery = mysqli_real_escape_string($conn, $_GET['search']); 
 
    $query = "SELECT p.id,username,title,cap,gif  
    FROM posts p JOIN users u ON u.id=p.author  
    WHERE title LIKE  '%" . $searchQuery . "%' OR cap LIKE '%" . $searchQuery . "%'"; 
    $res = mysqli_query($conn, $query); 
 
    while ($row = mysqli_fetch_assoc($res)) { 
        $posts[] = [ 
            "id_post" => $row["id"], 
            "author" => $row["username"], 
            "content" => array( 
                "title" => $row["title"], 
                "caption" => $row["cap"], 
                "gif" => $row["gif"] 
            ), 
            "searchedFor" => $searchQuery, 
            "numbersFound" => mysqli_num_rows($res) 
        ]; 
    } 
 
    if (!empty($posts)) echo json_encode($posts); 
    else echo 0; 
}

?>