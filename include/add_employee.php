<?php

session_start();
if ($_SESSION['loggedin'] !== true) {
    header("Location: ../public/login.php");
    exit;
}
require_once '../config/db.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $firstName = htmlspecialchars(trim($_POST['first_name']));
    $lastName = htmlspecialchars(trim($_POST['last_name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $dob = htmlspecialchars(trim($_POST['dob']));
    $gender = htmlspecialchars(trim($_POST['gender']));
    $documents = isset($_POST['documents']) ? $_POST['documents'] : [];

//i used php validation
    if(empty($firstName) || empty($lastName) || empty($email) || empty($dob) || empty($gender)){
        echo "Please provide all fields";
        exit();
    }

    if (!preg_match("/^[a-zA-Z]+$/", $firstName)) {
        echo  "Invalid First Name";
        exit();
    }

    if (!preg_match("/^[a-zA-Z]+$/", $lastName)) {
        echo "Invalid Last Name";       
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid Email";
        exit();
    }

    if ($dob > date("Y/m/d")) {
        echo "Invalid Date of Birth";
        exit();
    }

    if (!in_array($gender, ['Male', 'Female', 'Other'])) {
        echo "Invalid Gender";
        exit();
    }   

    
        

    $stmt = $conn->prepare("INSERT INTO employees (first_name, last_name, email, dob, gender) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $firstName, $lastName, $email, $dob, $gender);

        if ($stmt->execute()) {
            $employeeId = $stmt->insert_id;

        if ($documents) {
            $docStmt = $conn->prepare("INSERT INTO employee_documents (employee_id, document_type) VALUES (?, ?)");
            foreach ($documents as $doc) {
                $docStmt->bind_param("is", $employeeId, $doc);
                $docStmt->execute();
            }
            $docStmt->close();
        }

        echo "Employee added.";
        } else {
            http_response_code(500);
            echo "Insert error: " . $stmt->error;
        }

   

}



