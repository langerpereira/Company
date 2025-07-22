<?php
session_start();
require_once '../config/db.php';

$sql = "SELECT e.id, e.first_name, e.last_name, e.email, e.dob, e.gender, GROUP_CONCAT(d.document_type SEPARATOR ', ') AS documents FROM employees e LEFT JOIN employee_documents d ON e.id = d.employee_id GROUP BY e.id";


$result = $conn->query($sql);

$employees = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $employees[] = [
            "id" => $row['id'],
            "first_name" => $row['first_name'],
            "last_name" => $row['last_name'],
            "email" => $row['email'],
            "dob" => $row['dob'],
            "gender" => $row['gender'],
            "documents" => $row['documents'] ?? 'N/A'
        ];
    }
}

echo json_encode($employees);
?>
