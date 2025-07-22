<?php

session_start();
require_once '../config/db.php';

if($_SERVER["REQUEST_METHOD"] == 'POST'){
    $firstName = htmlspecialchars(trim($_POST['firstName']));
    $lastName = htmlspecialchars(trim($_POST['lastName']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = password_hash($_POST['password'],PASSWORD_DEFAULT);

    $error = false;
    if(empty($firstName) || empty($lastName) || empty($email) || empty($password)){
        echo "error";
        $error = true;
        header("Location: ../public/error.php");
        exit();
      }

    $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($checkEmail->num_rows > 0){
        $_SESSION['register_error'] = 'Email already existis';
        $_SESSION['active_form'] = 'register';
        header("Location: ../public/error.php");
        exit();
    }else{
        $conn->query("INSERT INTO users (first_name, last_name, email, password) VALUES( '$firstName', '$lastName', '$email', '$password' )");
    }

    header("Location: ../public/login.php");
    exit();
}

?>
