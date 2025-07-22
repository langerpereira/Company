<?php
include_once '../config/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $firstName = htmlspecialchars(trim($_POST['first_name']));
    $lastName = htmlspecialchars(trim($_POST['last_name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $dob = htmlspecialchars(trim($_POST['dob']));
    $gender = htmlspecialchars(trim($_POST['gender']));
    $documents = isset($_POST['documents']) ? $_POST['documents'] : [];


    $conn->begin_transaction();

    try {
        $stmt = $conn->prepare("UPDATE employees SET first_name = ?, last_name = ?, email = ?, dob = ?, gender = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $firstName, $lastName, $email, $dob, $gender, $id);
        $stmt->execute();
        $stmt->close();

        $stmt = $conn->prepare("DELETE FROM employee_documents WHERE employee_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();

        if (!empty($documents)) {
            $stmt = $conn->prepare("INSERT INTO employee_documents (employee_id, document_type) VALUES (?, ?)");
            foreach ($documents as $doc) {
                $stmt->bind_param("is", $id, $doc);
                $stmt->execute();
            }
            $stmt->close();
        }

        $conn->commit();
        echo "Employee updated successfully.";
    } catch (Exception $e) {
        $conn->rollback();
        echo "Error updating employee: " . $e->getMessage();
    }
}

$conn->close();
