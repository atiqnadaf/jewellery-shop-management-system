<?php
session_start();
include("../config/db.php");

/* ENABLE / DISABLE STAFF */
if (isset($_GET['toggle'])) {
    $id = $_GET['toggle'];
    mysqli_query($conn, "
        UPDATE users 
        SET status = IF(status='active','inactive','active') 
        WHERE id=$id AND role='staff'
    ");
    header("Location: staff.php");
    exit;
}

/* DELETE STAFF */
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM users WHERE id=$id AND role='staff'");
    header("Location: staff.php");
    exit;
}

/* ADD STAFF */
if (isset($_POST['add'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    mysqli_query($conn, "
        INSERT INTO users (username, password, role, status)
        VALUES ('$username', '$password', 'staff', 'active')
    ");
    header("Location: staff.php");
    exit;
}

/* UPDATE STAFF */
if (isset($_POST['update'])) {
    $id       = $_POST['id'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    mysqli_query($conn, "
        UPDATE users SET
            username='$username',
            password='$password'
        WHERE id=$id AND role='staff'
    ");
    header("Location: staff.php");
    exit;
}

/* EDIT FETCH */
$editData = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $res = mysqli_query($conn, "SELECT * FROM users WHERE id=$id AND role='staff'");
    $editData = mysqli_fetch_assoc($res);
}

/* STAFF LIST */
$staff = mysqli_query($conn, "
    SELECT * FROM users 
    WHERE role='staff' 
    ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Staff Management | JSMS</title>
    <link rel="stylesheet" href="../assets/css/base.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="../assets/css/staff.css">
</head>

<body>

<div class="dashboard">

    <div class="sidebar">
        <h3>JSMS Admin</h3>
        <a href="dashboard.php">Dashboard</a>
        <a href="inventory.php">Inventory</a>
        <a href="staff.php">Staff</a>
        <a href="customers.php">Customers</a>
        <a href="sales.php">Sales</a>
        <a href="reports.php">Reports</a>
        <a href="../logout/logout.php">Logout</a>
    </div>

    <div class="main-content">

        <div class="header">
            <h2>Staff Management</h2>
        </div>

        <div class="content">
            <div class="staff-wrapper">

                <!-- STAFF FORM -->
                <div class="staff-form">
                    <h3><?php echo $editData ? "Edit Staff" : "Add Staff"; ?></h3>

                    <form method="post">
                        <input type="hidden" name="id" value="<?php echo $editData['id'] ?? ''; ?>">

                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username"
                                   value="<?php echo $editData['username'] ?? ''; ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input type="text" name="password"
                                   value="<?php echo $editData['password'] ?? ''; ?>" required>
                        </div>

                        <button class="btn" name="<?php echo $editData ? 'update' : 'add'; ?>">
                            <?php echo $editData ? "Update Staff" : "Add Staff"; ?>
                        </button>
                    </form>
                </div>

                <!-- STAFF TABLE -->
                <div class="staff-table">
                    <h3>Staff List</h3>

                    <table>
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>

                        <?php
                        $i = 1;
                        while ($row = mysqli_fetch_assoc($staff)) {
                            $status = $row['status'] === 'active' ? 'Active' : 'Inactive';

                            echo "<tr>
                                <td>{$i}</td>
                                <td>{$row['username']}</td>
                                <td>{$status}</td>
                                <td>
                                    <a href='staff.php?edit={$row['id']}' class='btn'>Edit</a>
                                    <a href='staff.php?toggle={$row['id']}' class='btn'>Enable/Disable</a>
                                    <a href='staff.php?delete={$row['id']}'
                                       class='btn'
                                       onclick=\"return confirm('Delete staff?')\">Delete</a>
                                </td>
                            </tr>";
                            $i++;
                        }
                        ?>
                    </table>

                </div>

            </div>
        </div>
    </div>
</div>

</body>
</html>
