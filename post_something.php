<?php
require_once 'auth.php';
    if (!$id_user=checkAuth()) {
        header('Location: login.php');
        exit;
    }



    if(!empty($_POST['title']) && !empty($_POST['content'])){
            $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['pass'], $dbconfig['name']);
            $title = mysqli_real_escape_string($conn,$_POST['title']);
            $content = mysqli_real_escape_string($conn,$_POST['content']);
            $id = $_SESSION['user_id'];

            $query = "INSERT into post(author,title,contenuto) values ('$id',\"$title\",\"$content\")";
            if(mysqli_query($conn,$query)){
                $posted = true;
            }
            else $posted=false;
            mysqli_close($conn);

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel='stylesheet' href='navbar.css'>
    <link rel='stylesheet' href='post_something.css'>

</head>
<body>
    <navbar>
        <a href='home.php'>Home</a>
        <a href='profile.php'>Profile</a>
        <a class="color" href='post_something.php' >Post something</a>
        <a href='logout.php'>Logout</a>
    </navbar>

    <form method='post'>
        <h1>Nuovo post</h1>
        <textarea id='Titolo' name="title" placeholder="Titolo.."></textarea>
        <textarea name="content" placeholder="nuovo post..."></textarea>
        <label><input type="submit" value="pubblica">&nbsp;
    </form>

    <?php 
        if(isset($posted)){ 
                    echo '<div class="messageContainer"> 
                    <div class="messageTop">Post pubblicato!</div></div>'; 
                } else if($posted = false){ 
                    echo '<div class="messageContainer"> 
                    <div class="messageTop">Errore nella pubblicazione del post</div></div>'; 
                } 
        ?>

</body>
</html>