<?php
session_start();
include("../config/db.php");
include("../config/helpers.php");

/* FILTER VALUES */
$from = $_GET['from'] ?? '';
$to   = $_GET['to'] ?? '';
$staff = $_GET['staff'] ?? '';

/* BASE QUERY */
$query = "
    SELECT
        sales.quantity,
        sales.total_amount,
        sales.sold_by,
        sales.created_at,
        products.item_name,
        customers.name AS customer_name
    FROM sales
    JOIN products ON sales.product_id = products.id
    JOIN customers ON sales.customer_id = customers.id
    WHERE 1
";

/* APPLY FILTERS */
if ($from && $to) {
    $query .= " AND DATE(sales.created_at) BETWEEN '$from' AND '$to'";
}

if ($staff) {
    $query .= " AND sales.sold_by = '$staff'";
}

$query .= " ORDER BY sales.id DESC";

$sales = mysqli_query($conn, $query);

/* STAFF LIST FOR FILTER */
$staffList = mysqli_query($conn, "SELECT DISTINCT sold_by FROM sales");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reports | JSMS</title>
    <link rel="stylesheet" href="../assets/css/base.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="../assets/css/reports.css">
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
            <h2>Reports</h2>
        </div>

        <div class="content">

            <!-- FILTERS -->
            <form class="reports-filters" method="get">
                <div>
                    <label>From</label>
                    <input type="date" name="from" value="<?php echo $from; ?>">
                </div>

                <div>
                    <label>To</label>
                    <input type="date" name="to" value="<?php echo $to; ?>">
                </div>

                <div>
                    <label>Staff</label>
                    <select name="staff">
                        <option value="">All</option>
                        <?php while ($s = mysqli_fetch_assoc($staffList)) { ?>
                            <option value="<?php echo $s['sold_by']; ?>"
                                <?php if ($staff == $s['sold_by']) echo "selected"; ?>>
                                <?php echo ucfirst($s['sold_by']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div>
                    <button class="btn">Apply</button>
                </div>
            </form>

            <!-- REPORT TABLE -->
            <div class="reports-wrapper">
                <h3>Sales Report</h3>

                <table class="reports-table">
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Product</th>
                        <th>Customer</th>
                        <th>Qty</th>
                        <th>Amount</th>
                        <th>Sold By</th>
                    </tr>

                    <?php
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($sales)) {
                        echo "<tr>
                            <td>{$i}</td>
                            <td>" . date('d-m-Y', strtotime($row['created_at'])) . "</td>
                            <td>{$row['item_name']}</td>
                            <td>{$row['customer_name']}</td>
                            <td>{$row['quantity']}</td>
                            <td>₹" . formatINR($row['total_amount']) . "</td>
                            <td>" . ucfirst($row['sold_by']) . "</td>
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
