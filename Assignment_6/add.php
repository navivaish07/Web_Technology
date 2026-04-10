<?php
// Inserts a new employee record into the database.
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

    $sql = "INSERT INTO employee (emp_id, emp_name, age, gender, department, address, email, phone, joining_date, salary)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param(
        "isissssssd",
        $emp_id,
        $emp_name,
        $age,
        $gender,
        $department,
        $address,
        $email,
        $phone,
        $joining_date,
        $salary
    );

    if ($stmt->execute()) {
        echo "<script>alert('Employee record added successfully.'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Error adding record: " . addslashes($stmt->error) . "'); window.location.href='index.php';</script>";
    }

    $stmt->close();
}

$conn->close();
?>
