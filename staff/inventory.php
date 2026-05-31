<?php
session_start();
include("../config/db.php");
include("../config/helpers.php");

/* SECURITY CHECK */
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'staff') {
    header("Location: ../index.php");
    exit;
}

/* FETCH INVENTORY */
$res = mysqli_query($conn, "
    SELECT item_name, category, weight, price, quantity
    FROM products
    ORDER BY item_name
");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Inventory | Staff | JSMS</title>
    <link rel="stylesheet" href="../assets/css/base.css">
    <link rel="stylesheet" href="../assets/css/staff-inventory.css">
</head>

<body>

    <div class="dashboard">

        <!-- Sidebar -->
        <div class="sidebar">
            <h3>JSMS Staff</h3>
            <a href="dashboard.php">Dashboard</a>
            <a href="inventory.php" class="active">Inventory</a>
            <a href="customers.php">Customers</a>
            <a href="sales.php">Sales</a>
            <a href="../logout/logout.php">Logout</a>
        </div>

        <!-- Main -->
        <div class="main-content">

            <div class="header">
                <h2>Inventory</h2>
                <span>Stock overview</span>
            </div>

            <div class="content">

                <div class="inventory-card">
                    <h3>Available Jewellery Stock</h3>

                    <table>
                        <tr>
                            <th>#</th>
                            <th>Item</th>
                            <th>Category</th>
                            <th>Weight (gm)</th>
                            <th>Price (₹)</th>
                            <th>Qty</th>
                        </tr>

                        <?php
                        $i = 1;
                        while ($row = mysqli_fetch_assoc($res)) {
                            echo "<tr>
        <td>{$i}</td>
        <td>{$row['item_name']}</td>
        <td>{$row['category']}</td>
        <td>{$row['weight']}</td>
        <td>₹" . formatINR($row['price']) . "</td>
        <td>{$row['quantity']}</td>
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