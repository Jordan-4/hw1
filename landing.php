<?php

include 'auth.php';
if (checkAuth()) {
    header('Location: home.php');
    exit;
}

// LOGIN 

if (!empty($_POST["username"]) && !empty($_POST["password"])) {
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['pass'], $dbconfig['name']) or die(mysqli_error($conn));

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT id,username,password FROM users WHERE username = '" . $username . "'";
    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));

    if (mysqli_num_rows($res) > 0) {
        $entry = mysqli_fetch_assoc($res);

        // Hash check
        if (password_verify($_POST['password'], $entry['password'])) {
            $_SESSION["username"] = $entry["username"];
            $_SESSION["id"] = $entry["id"];

            header("Location: home.php");
            mysqli_free_result($res);
            mysqli_close($conn);
            exit;
        }
    }
    $l_error = "Check your credentials.";
} else if (!empty($_POST["username"]) || !empty($_POST["password"])) {
    $l_error = "Please fill out both fields.";
}


// SIGNUP 

if (
    !empty($_POST["email"]) && !empty($_POST["username"]) && !empty($_POST["password"])
) {
    $s_error = array();
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['pass'], $dbconfig['name']) or die(mysqli_error($conn));


    // Username check
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

    // password check
    if (strlen($_POST["password"]) < 8) {
        $s_error[] = "password is too weak: make it at least 8 characters";
    }

    // Email check
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
        $password = password_hash($password, password_BCRYPT);

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
