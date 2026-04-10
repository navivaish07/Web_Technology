<?php
// Deletes an employee record using the provided Employee ID.
require_once "connect.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $emp_id = (int) $_POST["emp_id"];

    $sql = "DELETE FROM employee WHERE emp_id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("i", $emp_id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo "<script>alert('Employee record deleted successfully.'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('No employee found with the given Employee ID.'); window.location.href='index.php';</script>";
        }
    } else {
        echo "<script>alert('Error deleting record: " . addslashes($stmt->error) . "'); window.location.href='index.php';</script>";
    }

    $stmt->close();
}

$conn->close();
?>
