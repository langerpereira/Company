<?php

session_start();
require_once '../config/db.php';


if($_SERVER["REQUEST_METHOD"] == 'POST'){
    $firstName = htmlspecialchars(trim($_POST['firstName']));
    $password = trim($_POST['password']);

     if (empty($firstName) || empty($password)) {
        echo "Email and Password are required.";
        exit;
    }

//    $result = $conn->query("SELECT * FROM users WHERE first_name = '$firstName'");
      $stmt = $conn -> prepare("SELECT * FROM users WHERE first_name = ?");
      $stmt->bind_param("s", $firstName);
      $stmt->execute();
      $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $user['id'];
            echo "success";
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "User not found.";
    }

}

?>
            
