<?php
// Simple admin dashboard with metrics and placeholders for charts.
require_once 'connect.php';

$stats = [
    'total' => 0,
    'departments' => 0,
    'photo_profiles' => 0,
    'new_this_month' => 0,
];

try {
    $res = $conn->query('SELECT COUNT(*) AS c FROM employee');
    if ($row = $res->fetch_assoc()) $stats['total'] = (int)$row['c'];

    $res = $conn->query('SELECT COUNT(DISTINCT department) AS c FROM employee');
    if ($row = $res->fetch_assoc()) $stats['departments'] = (int)$row['c'];

    // try to count photo profiles if column exists
    try {
        $res = $conn->query("SELECT COUNT(*) AS c FROM employee WHERE photo IS NOT NULL AND photo <> ''");
        if ($row = $res->fetch_assoc()) $stats['photo_profiles'] = (int)$row['c'];
    } catch (Exception $e) {
        $stats['photo_profiles'] = 0;
    }

    $res = $conn->query("SELECT COUNT(*) AS c FROM employee WHERE YEAR(joining_date)=YEAR(CURDATE()) AND MONTH(joining_date)=MONTH(CURDATE())");
    if ($row = $res->fetch_assoc()) $stats['new_this_month'] = (int)$row['c'];
} catch (Exception $e) {
    // leave defaults
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard — EmployeeHub</title>
    <link rel="stylesheet" href="style.css">
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
            <div class="container panel">
                <div class="topnav" style="margin-bottom:18px">
                    <div class="brand">
                        <div class="logo">EM</div>
                        <div>
                            <h3 style="margin:0">Employee Dashboard</h3>
                            <div class="muted">Monitor employee data and manage the team.</div>
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-secondary" onclick="document.body.classList.toggle('dark')">Dark Mode</button>
                        <a class="btn btn-secondary" href="display.php?admin=1">View All</a>
                        <a class="btn btn-primary" href="index.php">Add Employee</a>
                    </div>
                </div>

                <div class="cards-grid">
                    <div class="metric-card">
                        <h4>TOTAL EMPLOYEES</h4>
                        <p><?php echo $stats['total']; ?></p>
                        <div class="muted">Active records stored in the database.</div>
                    </div>
                    <div class="metric-card">
                        <h4>DEPARTMENTS</h4>
                        <p><?php echo $stats['departments']; ?></p>
                        <div class="muted">Distinct departments represented.</div>
                    </div>
                    <div class="metric-card">
                        <h4>PHOTO PROFILES</h4>
                        <p><?php echo $stats['photo_profiles']; ?></p>
                        <div class="muted">Employees with uploaded photo profile.</div>
                    </div>
                    <div class="metric-card">
                        <h4>NEW THIS MONTH</h4>
                        <p><?php echo $stats['new_this_month']; ?></p>
                        <div class="muted">Records added during the current month.</div>
                    </div>
                </div>

                <div style="display:grid;grid-template-columns:2fr 1fr; gap:18px;">
                    <div class="panel">
                        <h3>Department Distribution</h3>
                        <div class="muted">Employee count across the top departments.</div>
                        <div style="height:220px;display:flex;align-items:center;justify-content:center;">[Chart placeholder]</div>
                    </div>
                    <div class="panel">
                        <h3>Hiring Trend</h3>
                        <div class="muted">Employee records added over recent months.</div>
                        <div style="height:220px;display:flex;align-items:center;justify-content:center;">[Chart placeholder]</div>
                    </div>
                </div>

            </div>
        </main>
    </div>
</body>
</html>
