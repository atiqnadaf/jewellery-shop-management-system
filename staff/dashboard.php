<?php
session_start();
include("../config/db.php");
include("../config/helpers.php");

/* SECURITY CHECK */
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'staff') {
    header("Location: ../index.php");
    exit;
}

$staffName = $_SESSION['username'];

/* TOTAL SALES COUNT (STAFF ONLY) */
$resSales = mysqli_query($conn, "
    SELECT COUNT(*) AS total_sales
    FROM sales
    WHERE sold_by = '$staffName'
");
$salesData = mysqli_fetch_assoc($resSales);

/* TOTAL AMOUNT SOLD (STAFF ONLY) */
$resAmount = mysqli_query($conn, "
    SELECT SUM(total_amount) AS total_amount
    FROM sales
    WHERE sold_by = '$staffName'
");
$amountData = mysqli_fetch_assoc($resAmount);

/* LOW STOCK ALERT (COMMON INVENTORY) */
$lowStock = mysqli_query($conn, "
    SELECT item_name, quantity
    FROM products
    WHERE quantity <= 5
    ORDER BY quantity ASC
");

/* LAST 5 SALES (STAFF ONLY WITH CUSTOMER) */
$resRecent = mysqli_query($conn, "
    SELECT
        s.created_at,
        c.name AS customer_name,
        p.item_name,
        s.quantity,
        s.total_amount
    FROM sales s
    JOIN customers c ON s.customer_id = c.id
    JOIN products p ON s.product_id = p.id
    WHERE s.sold_by = '$staffName'
    ORDER BY s.created_at DESC
    LIMIT 5
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Staff Dashboard | JSMS</title>
    <link rel="stylesheet" href="../assets/css/base.css">
    <link rel="stylesheet" href="../assets/css/staff-dashboard.css">
</head>

<body>

<div class="dashboard">

    <!-- Sidebar -->
    <div class="sidebar">
        <h3>JSMS Staff</h3>
        <a href="dashboard.php">Dashboard</a>
        <a href="inventory.php">Inventory</a>
        <a href="customers.php">Customers</a>
        <a href="sales.php">Sales</a>
        <a href="../logout/logout.php">Logout</a>
    </div>

    <!-- Main -->
    <div class="main-content">

        <div class="header">
            <h2>Staff Dashboard</h2>
            <span>Welcome, <?php echo ucfirst($staffName); ?></span>
        </div>

        <div class="content">

            <!-- SUMMARY CARDS -->
            <div class="card-container">

                <div class="card">
                    <h4>Total Sales</h4>
                    <p><?php echo $salesData['total_sales'] ?? 0; ?></p>
                </div>

                <div class="card">
                    <h4>Total Amount Sold</h4>
                    <p>₹<?php echo formatINR($amountData['total_amount'] ?? 0); ?></p>
                </div>

            </div>

            <!-- RECENT SALES -->
            <div class="card recent-sales" style="margin-top:25px;">
                <h4>Recent 5 Sales</h4>

                <table>
                    <tr>
                        <th>Date</th>
                        <th>Customer</th>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Amount</th>
                    </tr>

                    <?php if (mysqli_num_rows($resRecent) > 0) { ?>
                        <?php while ($row = mysqli_fetch_assoc($resRecent)) { ?>
                            <tr>
                                <td><?php echo date("d-m-Y", strtotime($row['created_at'])); ?></td>
                                <td><?php echo $row['customer_name']; ?></td>
                                <td><?php echo $row['item_name']; ?></td>
                                <td style="text-align:center;"><?php echo $row['quantity']; ?></td>
                                <td style="text-align:right;">
                                    ₹<?php echo formatINR($row['total_amount']); ?>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="5" style="text-align:center;">
                                No sales yet
                            </td>
                        </tr>
                    <?php } ?>
                </table>

            </div>

        </div>
    </div>

</div>

</body>
</html>
