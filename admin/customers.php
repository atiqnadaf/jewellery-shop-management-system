<?php
session_start();
include("../config/db.php");

/* DELETE CUSTOMER */
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM customers WHERE id=$id");
    header("Location: customers.php");
    exit;
}

/* UPDATE CUSTOMER */
if (isset($_POST['update'])) {
    $id    = $_POST['id'];
    $name  = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $addr  = $_POST['address'];

    mysqli_query($conn, "UPDATE customers SET
        name='$name',
        phone='$phone',
        email='$email',
        address='$addr'
        WHERE id=$id
    ");

    header("Location: customers.php");
    exit;
}

/* ADD CUSTOMER */
if (isset($_POST['add'])) {
    $name  = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $addr  = $_POST['address'];

    mysqli_query($conn, "INSERT INTO customers
        (name, phone, email, address)
        VALUES ('$name','$phone','$email','$addr')
    ");

    header("Location: customers.php");
    exit;
}

/* EDIT FETCH */
$editData = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $res = mysqli_query($conn, "SELECT * FROM customers WHERE id=$id");
    $editData = mysqli_fetch_assoc($res);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customers | JSMS</title>
    <link rel="stylesheet" href="../assets/css/base.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="../assets/css/customers.css">
</head>

<body>

<div class="dashboard">

    <!-- Sidebar -->
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


    <!-- Main -->
    <div class="main-content">

        <div class="header">
            <h2>Customer Management</h2>
        </div>

        <!-- ✅ CORRECT LAYOUT -->
        <div class="content customer-layout">

            <!-- ✅ FORM -->
            <div class="customer-form">
                <h3><?php echo $editData ? "Edit Customer" : "Add Customer"; ?></h3>

                <form method="post">
                    <input type="hidden" name="id" value="<?php echo $editData['id'] ?? ''; ?>">

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name"
                               value="<?php echo $editData['name'] ?? ''; ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="phone"
                               value="<?php echo $editData['phone'] ?? ''; ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email"
                               value="<?php echo $editData['email'] ?? ''; ?>">
                    </div>

                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" name="address"
                               value="<?php echo $editData['address'] ?? ''; ?>">
                    </div>

                    <button class="btn" name="<?php echo $editData ? 'update' : 'add'; ?>">
                        <?php echo $editData ? "Update Customer" : "Add Customer"; ?>
                    </button>
                </form>
            </div>

            <!-- ✅ TABLE -->
            <div class="customer-table">
                <h3>Customer List</h3>

                <table>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>

                    <?php
                    $res = mysqli_query($conn, "SELECT * FROM customers ORDER BY id DESC");
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($res)) {
                        echo "<tr>
                            <td>{$i}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['phone']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['address']}</td>
                            <td>
                                <a href='customers.php?edit={$row['id']}' class='btn'>Edit</a>
                                <a href='customers.php?delete={$row['id']}'
                                   class='btn'
                                   onclick=\"return confirm('Delete customer?')\">Delete</a>
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

</body>
</html>
