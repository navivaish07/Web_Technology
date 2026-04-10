<?php
// Displays all employee records in a formatted HTML table.
require_once "connect.php";

$sql = "SELECT emp_id, emp_name, age, gender, department, address, email, phone, joining_date, salary
        FROM employee
        ORDER BY emp_id ASC";
$result = $conn->query($sql);
$isAdmin = isset($_GET['admin']) && $_GET['admin'] == '1';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Records</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="app-layout">
        <aside class="sidebar">
            <div class="logo">EM</div>
            <div style="margin-bottom:6px"><strong>EmployeeHub</strong><div class="muted">Admin Workspace</div></div>
            <nav>
                <a href="dashboard.php">Dashboard</a>
                <a href="index.php">Add Employee</a>
                <a href="display.php?admin=1" class="active">Manage Employees</a>
                <a href="#">Export Excel</a>
                <a href="#">Export PDF</a>
            </nav>
            <div style="margin-top:18px" class="muted">Signed in as <strong>admin</strong></div>
        </aside>

        <main class="main-content">
        <div class="wrapper panel">
        <div class="topnav">
            <div class="brand">
                <div class="logo">EM</div>
                <div>
                    <h3 style="margin:0;">Employee Management</h3>
                    <div class="muted">Records overview</div>
                </div>
            </div>
            <div>
                <?php if ($isAdmin): ?>
                    <a class="btn btn-secondary" href="index.php">New Employee</a>
                <?php endif; ?>
                <a class="btn btn-primary" href="display.php<?php echo $isAdmin? '?admin=1':''; ?>">Refresh</a>
            </div>
        </div>

        <?php if ($result && $result->num_rows > 0): ?>
            <div class="table-responsive">
            <table class="compact">
                <thead>
                    <tr>
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Department</th>
                        <th>Address</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Joining Date</th>
                        <th>Salary</th>
                        <?php if ($isAdmin): ?>
                            <th>Actions</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row["emp_id"]); ?></td>
                            <td><?php echo htmlspecialchars($row["emp_name"]); ?></td>
                            <td><?php echo htmlspecialchars($row["age"]); ?></td>
                            <td><?php echo htmlspecialchars($row["gender"]); ?></td>
                            <td><?php echo htmlspecialchars($row["department"]); ?></td>
                            <td><?php echo htmlspecialchars($row["address"]); ?></td>
                            <td><?php echo htmlspecialchars($row["email"]); ?></td>
                            <td><?php echo htmlspecialchars($row["phone"]); ?></td>
                            <td><?php echo htmlspecialchars($row["joining_date"]); ?></td>
                            <td><?php echo htmlspecialchars(number_format((float) $row["salary"], 2)); ?></td>
                            <?php if ($isAdmin): ?>
                                <td class="table-actions">
                                    <button class="btn btn-danger" type="button" data-emp-id="<?php echo htmlspecialchars($row['emp_id']); ?>" data-emp-name="<?php echo htmlspecialchars($row['emp_name']); ?>" onclick="openDeleteModal(this)">
                                        <!-- trash svg -->
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle;margin-right:6px"><path d="M3 6h18" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M8 6v14a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2V6" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M10 11v6" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M14 11v6" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        Delete
                                    </button>
                                    <a class="btn btn-secondary" href="index.php?edit=<?php echo urlencode($row['emp_id']); ?>">
                                        <!-- edit svg -->
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle;margin-right:6px"><path d="M3 21v-3.75L14.81 5.44a2 2 0 0 1 2.83 0l2.92 2.92a2 2 0 0 1 0 2.83L8.75 21H3z" stroke="#0f1724" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        Edit
                                    </a>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            </div>
        <?php else: ?>
            <p class="empty">No employee records found.</p>
        <?php endif; ?>

        <a class="back-link" href="index.php">Back to Form</a>
    </div>

    <!-- Delete confirmation modal -->
    <div id="modalBackdrop" class="modal-backdrop">
        <div class="modal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
            <h3 id="modalTitle">Confirm Deletion</h3>
            <p id="modalText">Are you sure you want to delete this employee?</p>
            <form id="modalForm" method="post" action="delete.php">
                <input type="hidden" name="emp_id" id="modalEmpId" value="">
                <div class="modal-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openDeleteModal(btn){
            const id = btn.getAttribute('data-emp-id');
            const name = btn.getAttribute('data-emp-name');
            document.getElementById('modalEmpId').value = id;
            document.getElementById('modalText').textContent = 'Delete employee "' + name + '" (ID: ' + id + ')? This action cannot be undone.';
            document.getElementById('modalBackdrop').style.display = 'flex';
        }
        function closeDeleteModal(){
            document.getElementById('modalBackdrop').style.display = 'none';
        }
        // close modal on ESC
        document.addEventListener('keydown', function(e){ if(e.key === 'Escape'){ closeDeleteModal(); } });
    </script>
</body>
</html>
<?php
if ($result) {
    $result->free();
}

$conn->close();
?>
