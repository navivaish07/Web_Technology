<?php
// Updates an existing employee record using the supplied Employee ID.
require_once "connect.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $emp_id = (int) $_POST["emp_id"];
    $emp_name = trim($_POST["emp_name"]);
    $age = (int) $_POST["age"];
    $gender = trim($_POST["gender"]);
    $department = trim($_POST["department"]);
    $address = trim($_POST["address"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $joining_date = $_POST["joining_date"];
    $salary = (float) $_POST["salary"];

    $sql = "UPDATE employee
            SET emp_name = ?, age = ?, gender = ?, department = ?, address = ?, email = ?, phone = ?, joining_date = ?, salary = ?
            WHERE emp_id = ?";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param(
        "sissssssdi",
        $emp_name,
        $age,
        $gender,
        $department,
        $address,
        $email,
        $phone,
        $joining_date,
        $salary,
        $emp_id
    );

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo "<script>alert('Employee record updated successfully.'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('No matching employee found or no changes were made.'); window.location.href='index.php';</script>";
        }
    } else {
        echo "<script>alert('Error updating record: " . addslashes($stmt->error) . "'); window.location.href='index.php';</script>";
    }

    $stmt->close();
}

$conn->close();
?>
