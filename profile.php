<?php
require_once 'auth.php';
    if (!$id_user=checkAuth()) {
        header('Location: login.php');
        exit;
    }

?>
<!DOCTYPE html> 
<html lang="en"> 

<?php 
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['pass'], $dbconfig['name']); 
    $id_user = mysqli_real_escape_string($conn, $id_user); 
    $query = "SELECT * FROM users WHERE id = $id_user"; 
    $res__u = mysqli_query($conn, $query); 
    $userinfo = mysqli_fetch_assoc($res__u); 
    ?>

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel='stylesheet' href='home.css'>
        <script src='profile.js'></script>
        <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@200&family=Montserrat:wght@200&family=Playfair+Display&family=Questrial&display=swap" rel="stylesheet">
    </head>

        <body>
            <navbar>
                <a href='home.php'>Home</a>
                <a href='profile.php'>Profile</a>
                <a class="color" href='post_something.php' >Post something</a>
                <a href='logout.php'>Logout</a>
            </navbar>
            
            <header>
                <div id="static">
                <h1>Your Profile</h1>
                </div>
                <div id="overlay"></div>
            </header>
            
            <div id="profile"> 
                <img id="propic" src="pfp.png"/>
            </div>
            
            <div class="dati">
                <strong><?php echo $userinfo['username'] ?></strong><br>
                <em>Last update: today</em> 
            </div>

            <div class='post_home'>
                <article>
                    
                </article>
            </div>
        </body>

        <footer>
            <p> <em>Jordan Codice</em> <br>
            1000001433 
            </p>
        </footer>
</html>