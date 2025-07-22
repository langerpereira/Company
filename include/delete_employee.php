
<?php
session_start();
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    $conn->begin_transaction();

    try {
        $stmt1 = $conn->prepare("DELETE FROM employee_documents WHERE employee_id = ?");
        $stmt1->bind_param("i", $id);
        $stmt1->execute();

        $stmt2 = $conn->prepare("DELETE FROM employees WHERE id = ?");
        $stmt2->bind_param("i", $id);
        $stmt2->execute();

        $conn->commit();

        echo "✅ Employee and their documents deleted successfully.";
    } catch (Exception $e) {
        $conn->rollback();

        echo "❌ Error occurred: " . $e->getMessage();
    }

    $stmt1->close();
    $stmt2->close();
}

$conn->close();
?>
