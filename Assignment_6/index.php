<?php
// Main form page for employee CRUD operations with edit-prefill support.
require_once 'connect.php';

$editData = [];
if (isset($_GET['edit'])) {
    $eid = (int) $_GET['edit'];
    $stmt = $conn->prepare('SELECT emp_id, emp_name, age, gender, department, address, email, phone, joining_date, salary FROM employee WHERE emp_id = ?');
    if ($stmt) {
        $stmt->bind_param('i', $eid);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($row = $res->fetch_assoc()) {
            $editData = $row;
        }
        $stmt->close();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Employee Management</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function validateForm(actionType) {
            const form = document.forms["empForm"];
            const id = form["emp_id"].value.trim();
            const name = form["emp_name"].value.trim();
            const age = form["age"].value.trim();
            const gender = form["gender"].value.trim();
            const dept = form["department"].value.trim();
            const address = form["address"].value.trim();
            const email = form["email"].value.trim();
            const phone = form["phone"].value.trim();
            const joiningDate = form["joining_date"].value.trim();
            const salary = form["salary"].value.trim();

            if (actionType === "delete") {
                if (id === "" || isNaN(id)) {
                    alert("Enter a valid numeric Employee ID to delete a record.");
                    return false;
                }
                return confirm('Are you sure you want to delete employee ID ' + id + '?');
            }

            if (actionType === "display") {
                return true;
            }

            if (
                id === "" || name === "" || age === "" || gender === "" ||
                dept === "" || address === "" || email === "" ||
                phone === "" || joiningDate === "" || salary === ""
            ) {
                alert("All fields must be filled out.");
                return false;
            }

            if (isNaN(id)) {
                alert("Employee ID must be a number.");
                return false;
            }

            if (isNaN(age)) {
                alert("Age must be a number.");
                return false;
            }

            if (isNaN(salary)) {
                alert("Salary must be a number.");
                return false;
            }

            if (isNaN(phone) || phone.length !== 10) {
                alert("Phone number must be a valid 10-digit number.");
                return false;
            }

            const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,}$/i;
            if (!emailPattern.test(email)) {
                alert("Enter a valid email address.");
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    <div class="app-layout">
        <aside class="sidebar">
            <div class="logo">EM</div>
            <div style="margin-bottom:6px"><strong>EmployeeHub</strong><div class="muted">Admin Workspace</div></div>
            <nav>
                <a href="dashboard.php" class="active">Dashboard</a>
                <a href="index.php">Add Employee</a>
                <a href="display.php?admin=1">Manage Employees</a>
                <a href="#">Export Excel</a>
                <a href="#">Export PDF</a>
            </nav>
            <div style="margin-top:18px" class="muted">Signed in as <strong>admin</strong></div>
        </aside>

        <main class="main-content">
        <div class="container">
        <div class="admin-header" style="align-items:center;">
            <div style="display:flex;align-items:center;gap:12px;">
                <div style="width:48px;height:48px;border-radius:8px;background:linear-gradient(135deg,var(--primary),var(--accent));display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;">EM</div>
                <div>
                    <h1 style="margin:0;font-size:1.05rem;">Employee Admin</h1>
                    <div class="muted">Manage records — add, edit or remove employees</div>
                </div>
            </div>
            <div class="admin-actions">
                <a href="display.php?admin=1" class="btn btn-secondary">View Employees</a>
                <a href="index.php" class="btn btn-primary">New Employee</a>
            </div>
        </div>

        <div class="panel">
        <h2 style="margin-top:0;">Employee Details</h2>
        <form name="empForm" method="post">
            <div class="form-grid">
                <div class="field field-full">
                    <label for="emp_id">Employee ID</label>
                    <input type="number" id="emp_id" name="emp_id" placeholder="Enter employee ID" value="<?php echo isset($editData['emp_id'])?htmlspecialchars($editData['emp_id']):''; ?>">
                </div>

                <div class="field field-full">
                    <label for="emp_name">Employee Name</label>
                    <input type="text" id="emp_name" name="emp_name" placeholder="Enter full name" value="<?php echo isset($editData['emp_name'])?htmlspecialchars($editData['emp_name']):''; ?>">
                </div>

                <div class="field">
                    <label for="age">Age</label>
                    <input type="number" id="age" name="age" placeholder="Enter age" value="<?php echo isset($editData['age'])?htmlspecialchars($editData['age']):''; ?>">
                </div>

                <div class="field">
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender">
                        <option value="">Select gender</option>
                        <option value="Male" <?php echo (isset($editData['gender']) && $editData['gender']==='Male')?'selected':''; ?>>Male</option>
                        <option value="Female" <?php echo (isset($editData['gender']) && $editData['gender']==='Female')?'selected':''; ?>>Female</option>
                        <option value="Other" <?php echo (isset($editData['gender']) && $editData['gender']==='Other')?'selected':''; ?>>Other</option>
                    </select>
                </div>

                <div class="field">
                    <label for="department">Department</label>
                    <input type="text" id="department" name="department" placeholder="Enter department" value="<?php echo isset($editData['department'])?htmlspecialchars($editData['department']):''; ?>">
                </div>

                <div class="field">
                    <label for="address">Address</label>
                    <textarea id="address" name="address" placeholder="Enter address"><?php echo isset($editData['address'])?htmlspecialchars($editData['address']):''; ?></textarea>
                </div>

                <div class="field field-full">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter email address" value="<?php echo isset($editData['email'])?htmlspecialchars($editData['email']):''; ?>">
                </div>

                <div class="field">
                    <label for="phone">Phone Number</label>
                    <input type="text" id="phone" name="phone" maxlength="10" placeholder="Enter 10-digit phone number" value="<?php echo isset($editData['phone'])?htmlspecialchars($editData['phone']):''; ?>">
                </div>

                <div class="field">
                    <label for="joining_date">Joining Date</label>
                    <input type="date" id="joining_date" name="joining_date" value="<?php echo isset($editData['joining_date'])?htmlspecialchars($editData['joining_date']):''; ?>">
                </div>

                <div class="field field-full">
                    <label for="salary">Salary</label>
                    <input type="number" step="0.01" id="salary" name="salary" placeholder="Enter salary" value="<?php echo isset($editData['salary'])?htmlspecialchars($editData['salary']):''; ?>">
                </div>
            </div>

            <div class="actions">
                <button type="submit" class="btn btn-primary" formaction="add.php" onclick="return validateForm('add');">Add Employee</button>
                <button type="submit" class="btn btn-primary" formaction="update.php" onclick="return validateForm('update');">Save Changes</button>
                <button type="submit" class="btn btn-danger" formaction="delete.php" onclick="return validateForm('delete');">Delete</button>
                <button type="submit" class="btn btn-secondary" formmethod="get" formaction="display.php" onclick="return validateForm('display');">View All</button>
            </div>
        </form>
        <p class="note">Use Employee ID for update and delete operations. Use the Edit button from the employee list to load details for editing.</p>
        </div>
        </div>
        </main>
    </div>
</body>
</html>
