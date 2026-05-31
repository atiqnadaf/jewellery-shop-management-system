<?php
session_start();
include("../config/db.php");

/* ALLOW ONLY STAFF */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'staff') {
    header("Location: ../auth/login.php");
    exit;
}

$staffName = $_SESSION['username'];

/* FETCH CUSTOMERS */
$customers = mysqli_query($conn, "SELECT id, name FROM customers ORDER BY name");

/* FETCH PRODUCTS (IN STOCK) */
$products = mysqli_query($conn, "
    SELECT id, item_name, price, quantity
    FROM products
    WHERE quantity > 0
    ORDER BY item_name
");

/* HANDLE SALE */
if (isset($_POST['sell'])) {

    $customer_id = $_POST['customer_id'];
    $product_id  = $_POST['product_id'];
    $qty         = (int) $_POST['quantity'];

    $res = mysqli_query($conn, "SELECT price, quantity FROM products WHERE id=$product_id");
    $product = mysqli_fetch_assoc($res);

    if ($qty > $product['quantity']) {
        echo "<script>alert('Not enough stock');</script>";
    } else {

        $total = $product['price'] * $qty;

        mysqli_query($conn, "INSERT INTO sales
            (customer_id, product_id, quantity, total_amount, sold_by)
            VALUES ($customer_id, $product_id, $qty, $total, '$staffName')
        ");

        mysqli_query($conn, "UPDATE products
            SET quantity = quantity - $qty
            WHERE id=$product_id
        ");

        header("Location: sales.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Staff Sales | JSMS</title>
    <link rel="stylesheet" href="../assets/css/base.css">
   <link rel="stylesheet" href="../assets/css/staff-sales.css">
</head>

<body>

<div class="dashboard">

    <!-- STAFF SIDEBAR -->
    <div class="sidebar">
    <h3>JSMS Staff</h3>
    <a href="dashboard.php">Dashboard</a>
    <a href="inventory.php">Inventory</a>
    <a href="customers.php">Customers</a>
    <a href="sales.php">Sales</a>
    <a href="../logout/logout.php">Logout</a>
</div>



    <!-- MAIN -->
    <div class="main-content">

        <div class="header">
            <h2>Sales Entry</h2>
            <span>Staff: <?php echo htmlspecialchars($staffName); ?></span>
        </div>

        <div class="content sales-layout">

            <div class="sales-form">
                <h3>Create Sale</h3>

                <form method="post">

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
                                    (₹<?php echo $p['price']; ?> | Stock: <?php echo $p['quantity']; ?>)
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
