<?php
session_start();

include("../config/db.php");
include("../config/helpers.php");

/* TOTAL PRODUCTS */
$resProducts = mysqli_query($conn, "SELECT COUNT(*) AS total FROM products");
$productsData = mysqli_fetch_assoc($resProducts);

/* TOTAL CUSTOMERS */
$resCustomers = mysqli_query($conn, "SELECT COUNT(*) AS total FROM customers");
$customersData = mysqli_fetch_assoc($resCustomers);

/* TOTAL SALES COUNT */
$resSales = mysqli_query($conn, "SELECT COUNT(*) AS total FROM sales");
$salesData = mysqli_fetch_assoc($resSales);

/* TOTAL SALES AMOUNT */
$resRevenue = mysqli_query($conn, "SELECT SUM(total_amount) AS revenue FROM sales");
$revenueData = mysqli_fetch_assoc($resRevenue);

/* STOCK AVAILABLE */
$resStock = mysqli_query($conn, "SELECT SUM(quantity) AS stock FROM products");
$stockData = mysqli_fetch_assoc($resStock);

/* LOW STOCK ALERT */
$lowStock = mysqli_query($conn, "
    SELECT item_name, quantity
    FROM products
    WHERE quantity <= 5
    ORDER BY quantity ASC
");

/* RECENT 5 SALES */
$recentSales = mysqli_query($conn, "
    SELECT
        sales.total_amount,
        sales.sold_by,
        sales.created_at,
        products.item_name,
        customers.name AS customer_name
    FROM sales
    JOIN products ON sales.product_id = products.id
    JOIN customers ON sales.customer_id = customers.id
    ORDER BY sales.id DESC
    LIMIT 5
");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard | Jewellery Shop Management System</title>
    <link rel="stylesheet" href="../assets/css/base.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
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

        <!-- Main Area -->
        <div class="main-content">

            <!-- Header -->
            <div class="header">
                <h2>Admin Dashboard</h2>
                <span>Welcome, Admin</span>
            </div>

            <!-- Content -->
            <div class="content">



                <!-- CARDS -->
                <div class="card-container">

                    <div class="card">
                        <h4>Total Products</h4>
                        <p><?php echo $productsData['total']; ?></p>
                    </div>

                    <div class="card">
                        <h4>Total Customers</h4>
                        <p><?php echo $customersData['total']; ?></p>
                    </div>

                    <div class="card">
                        <h4>Total Sales</h4>
                        <p><?php echo $salesData['total']; ?></p>
                    </div>

                    <div class="card">
                        <h4>Total Revenue</h4>
                        <p>₹<?php echo formatINR($revenueData['revenue']); ?></p>
                    </div>

                    <div class="card">
                        <h4>Stock Available</h4>
                        <p><?php echo $stockData['stock'] ?? 0; ?></p>
                    </div>

                </div>

                <!-- RECENT SALES -->
                <div class="card" style="margin-top:30px;">
                    <h4>Recent Sales</h4>

                    <table style="width:100%; font-size:13px; border-collapse:collapse;">
                        <tr>
                            <th style="text-align:left; padding:6px;">Product</th>
                            <th style="text-align:left; padding:6px;">Customer</th>
                            <th style="text-align:left; padding:6px;">Sold By</th>
                            <th style="text-align:right; padding:6px;">Amount</th>
                        </tr>

                        <?php while ($row = mysqli_fetch_assoc($recentSales)) { ?>
                            <tr>
                                <td style="padding:6px;"><?php echo $row['item_name']; ?></td>
                                <td style="padding:6px;"><?php echo $row['customer_name']; ?></td>
                                <td style="padding:6px;"><?php echo ucfirst($row['sold_by']); ?></td>
                                <td style="padding:6px; text-align:right;">
                                    ₹<?php echo formatINR($row['total_amount']); ?>
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