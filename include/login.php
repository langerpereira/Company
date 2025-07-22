<?php

session_start();
require_once '../config/db.php';


if($_SERVER["REQUEST_METHOD"] == 'POST'){
    $firstName = htmlspecialchars(trim($_POST['firstName']));
    $password = trim($_POST['password']);

     if (empty($firstName) || empty($password)) {
        $_SESSION['login_error'] = 'Please fill in all fields.';
        header("Location: ../public/error.php");
        exit();
    }

//    $result = $conn->query("SELECT * FROM users WHERE first_name = '$firstName'");
      $stmt = $conn -> prepare("SELECT * FROM users WHERE first_name = ?");
      $stmt->bind_param("s", $firstName);
      $stmt->execute();
      $result = $stmt->get_result();
      
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

          if (password_verify($password, $user['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['first_name'];
            header("Location: ../public/index.php");
            exit();
        }
        else {
            $_SESSION['login_error'] = 'Wrong password.';
            header("Location: ../public/error.php");
            exit();
        }
        
    } else {
        $_SESSION['login_error'] = 'User not found.';
        header("Location: ../public/error.php");
        exit();
    }

}

?>