<?php
require_once 'dbconfig.php';
if (
    !empty($_POST["email"]) && !empty($_POST["username"]) && !empty($_POST["password"])
) {
    $s_error = array();
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['pass'], $dbconfig['name']) or die(mysqli_error($conn));


    
    if (!preg_match('/^[a-zA-Z0-9_]{1,16}$/', $_POST['username'])) {
        $s_error[] = "Invalid username";
    } else {
        $username = mysqli_real_escape_string($conn, $_POST['username']);

        $query = "SELECT username FROM users WHERE username = '" . $username . "'";
        $res = mysqli_query($conn, $query);

        if (mysqli_num_rows($res) > 0) {
            $s_error[] = "This username is already taken";
        }
    }

    
    if (strlen($_POST["password"]) < 8) {
        $s_error[] = "password is too weak: make it at least 8 characters";
    }

    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $s_error[] = "Invalid email address";
    } else {
        $email = mysqli_real_escape_string($conn, strtolower($_POST['email']));

        $res = mysqli_query($conn, "SELECT email FROM users WHERE email = '" . $email . "'");
        if (mysqli_num_rows($res) > 0) {
            $s_error[] = "This email is already taken";
        }
    }

    
    if (count($s_error) == 0) {
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $password = password_hash($password, PASSWORD_BCRYPT);

        $query = "INSERT INTO users(username, password, email) VALUES('$username', '$password', '$email')";

        if (mysqli_query($conn, $query)) {
            $_SESSION["username"] = $_POST["username"];
            $_SESSION["id"] = mysqli_insert_id($conn);
            mysqli_close($conn);
            header("Location: home.php");
            exit;
        } else {
            $s_error[] = "Cannot communicate with database!";
        }
    }

    mysqli_close($conn);
} else if (isset($_POST["username"])) {
    $s_error = array("Riempi tutti i campi");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src='landing.js' defer="true"></script>
    <link rel='stylesheet' href='login.css'>
    <title>Document</title>
</head>
<body>


<div class="wrapper">
    <form name='signup_form' class="form-signin" method='post'>       
        <h2 class="form-signin-heading">Please register</h2>
        <input type="text" class="form-control" name="username" placeholder="Username" required="" autofocus="" />
        <div id='err_user' class='signup_error hidden'>Invalid username (16 char max)</div>
        <input type="email" class="form-control-mail" name="email" placeholder="Email Address" required="" autofocus="" />
        <div id='err_email' class='signup_error hidden'>Invalid email</div>
        <input type="password" class="form-control" name="password" placeholder="Password" required=""/> 
        <div id='err_pass' class='signup_error hidden'>Make password atleast 8 char max</div>
        <input class="btn btn-2" type="submit" value='Register'>   
    </form>
</div>
</body>
</html>

