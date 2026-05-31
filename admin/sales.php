<?php
session_start();

include("../config/db.php");
include("../config/helpers.php");

/* FETCH CUSTOMERS */
$customers = mysqli_query($conn, "SELECT id, name FROM customers ORDER BY name");

/* FETCH PRODUCTS */
$products = mysqli_query($conn, "SELECT id, item_name, price, quantity
                                 FROM products
                                 WHERE quantity > 0
                                 ORDER BY item_name");

/* HANDLE SALE */
if (isset($_POST['sell'])) {

    $customer_id = $_POST['customer_id'];
    $product_id  = $_POST['product_id'];
    $qty         = (int) $_POST['quantity'];
    $sale_date   = $_POST['sale_date'] ?? '';

    /* Fetch product price & current stock */
    $res = mysqli_query($conn, "SELECT price, quantity FROM products WHERE id=$product_id");
    $product = mysqli_fetch_assoc($res);

    $price = $product['price'];
    $stock = $product['quantity'];

    /* Stock validation */
    if ($qty > $stock) {
        echo "<script>alert('Not enough stock available');</script>";
    } else {

        $total = $price * $qty;

        /* INSERT SALE (WITH OR WITHOUT DATE) */
        if (!empty($sale_date)) {
            $sale_date = $sale_date . " 12:00:00";
            mysqli_query($conn, "INSERT INTO sales
                (customer_id, product_id, quantity, total_amount, sold_by, created_at)
                VALUES ($customer_id, $product_id, $qty, $total, 'admin', '$sale_date')
            ");
        } else {
            mysqli_query($conn, "INSERT INTO sales
                (customer_id, product_id, quantity, total_amount, sold_by)
                VALUES ($customer_id, $product_id, $qty, $total, 'admin')
            ");
        }

        /* Reduce stock */
        mysqli_query($conn, "UPDATE products
            SET quantity = quantity - $qty
            WHERE id = $product_id
        ");

        header("Location: sales.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sales | JSMS</title>
    <link rel="stylesheet" href="../assets/css/base.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="../assets/css/sales.css">
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
            <h2>Sales Entry (Admin)</h2>
        </div>

        <div class="content sales-layout">

            <div class="sales-form">
                <h3>Create Sale</h3>

                <form method="post">

                    <!-- DATE (ADMIN TESTING ONLY) -->
                    <div class="form-group">
                        <label>Sale Date (optional)</label>
                        <input type="date" name="sale_date">
                    </div>

                    <div class="form-group">
                        <label>Customer</label>
                        <select name="customer_id" required>
                            <option value="">Select Customer</option>
                            <?php while ($c = mysqli_fetch_assoc($customers)) { ?>
                                <option value="<?php echo $c['id']; ?>">
                                    <?php echo $c['name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Product</label>
                        <select name="product_id" required>
                            <option value="">Select Product</option>
                            <?php while ($p = mysqli_fetch_assoc($products)) { ?>
                                <option value="<?php echo $p['id']; ?>">
                                    <?php echo $p['item_name']; ?>
                                    (₹<?php echo formatINR($p['price']); ?> | Stock: <?php echo $p['quantity']; ?>)
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Quantity</label>
                        <input type="number" name="quantity" min="1" required>
                    </div>

                    <button class="btn" name="sell">Complete Sale</button>

                </form>
            </div>

        </div>
    </div>

</div>

</body>
</html>
