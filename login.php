<?php
    
    include 'auth.php';
    if (checkAuth()) {
        header('Location: home.php');
        exit;
    }

    if (!empty($_POST["username"]) && !empty($_POST["password"]) )
    {
       
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['pass'], $dbconfig['name']) or die(mysqli_error($conn));
       
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        
        $query = "SELECT id, username, password FROM users WHERE username = '$username'";
      one
        $res = mysqli_query($conn, $query) or die(mysqli_error($conn));;
        if (mysqli_num_rows($res) > 0) {
            
            $entry = mysqli_fetch_assoc($res);
            if (password_verify($_POST['password'], $entry['password'])) {

                
                $_SESSION["username"] = $entry['username'];
                $_SESSION["user_id"] = $entry['id'];
                header("Location: home.php");
                mysqli_free_result($res);
                mysqli_close($conn);
                exit;
            }
        }
      
        $error = "Username e/o password errati.";
    }
    else if (isset($_POST["username"]) || isset($_POST["password"])) {
       
        $error = "Inserisci username e password.";
    }

    if (!empty($_POST["username"]) && !empty($_POST["password"])) {
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['pass'], $dbconfig['name']) or die(mysqli_error($conn));
    
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
    
        $query = "SELECT id,username,password FROM users WHERE username = '" . $username . "'";
        $res = mysqli_query($conn, $query) or die(mysqli_error($conn));
    
        if (mysqli_num_rows($res) > 0) {
            $entry = mysqli_fetch_assoc($res);
    
            
            if (password_verify($_POST['password'], $entry['password'])) {
                $_SESSION["username"] = $entry["username"];
                $_SESSION["id"] = $entry["id"];
    
                header("Location: home.php");
                mysqli_free_result($res);
                mysqli_close($conn);
                exit;
            }
        }
        $l_error = "Wrong username or password ";
    } else if (!empty($_POST["username"]) || !empty($_POST["password"])) {
        $l_error = "Please fill out both fields.";
    }

?>



<html>
        <head>
            <link rel='stylesheet' href='login.css'>
        </head>
    <body>
        <div class="wrapper">
            <form name='signup_form' method='post' class="form-signin">       
            <h2 class="form-signin-heading">Please login</h2>
            <input type="text" class="form-control" name="username" placeholder="Username" required="" autofocus="" />
            <input type="password" class="form-control" name="password" placeholder="Password" required=""/> 
            
            <?php
                        if (isset($l_error)) {
                            echo "<span class='error'>$l_error</span>";
                        }
                ?>
                
            <input class="btn" type="submit" value='Login'>
            <input value= 'Register' class="btn btn-2" type="button" id='register' onClick="document.location.href='signup.php'">
            </form>
          

        </div>
    </body>
    </html>

    