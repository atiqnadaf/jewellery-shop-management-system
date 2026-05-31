<?php
session_start();
include("../config/db.php");
include("../config/helpers.php");

/* DELETE */
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM products WHERE id=$id");
    header("Location: inventory.php");
    exit;
}

/* UPDATE */
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $item = $_POST['item_name'];
    $cat = $_POST['category'];
    $weight = $_POST['weight'];
    $price = $_POST['price'];
    $qty = $_POST['quantity'];

    mysqli_query($conn, "UPDATE products SET
        item_name='$item',
        category='$cat',
        weight='$weight',
        price='$price',
        quantity='$qty'
        WHERE id=$id
    ");

    header("Location: inventory.php");
    exit;
}

/* INSERT */
if (isset($_POST['add'])) {
    $item = $_POST['item_name'];
    $cat = $_POST['category'];
    $weight = $_POST['weight'];
    $price = $_POST['price'];
    $qty = $_POST['quantity'];

    mysqli_query($conn, "INSERT INTO products
        (item_name, category, weight, price, quantity)
        VALUES ('$item','$cat','$weight','$price','$qty')
    ");

    header("Location: inventory.php");
    exit;
}

/* EDIT FETCH */
$editData = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $res = mysqli_query($conn, "SELECT * FROM products WHERE id=$id");
    $editData = mysqli_fetch_assoc($res);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inventory | JSMS</title>
    <link rel="stylesheet" href="../assets/css/base.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="../assets/css/inventory.css">
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
            <h2>Inventory Management</h2>
        </div>

        <div class="content inventory-layout">

            <!-- FORM -->
            <div class="inventory-form">
                <h3><?php echo $editData ? "Edit Item" : "Add Item"; ?></h3>

                <form method="post">
                    <input type="hidden" name="id" value="<?php echo $editData['id'] ?? ''; ?>">

                    <div class="form-group">
                        <label>Item Name</label>
                        <input type="text" name="item_name"
                               value="<?php echo $editData['item_name'] ?? ''; ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Category</label>
                        <select name="category" required>
                            <option value="">Select</option>
                            <?php
                            $cats = ["Gold", "Silver", "Diamond"];
                            foreach ($cats as $c) {
                                $sel = ($editData && $editData['category'] == $c) ? "selected" : "";
                                echo "<option $sel>$c</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Weight (gm)</label>
                        <input type="number" step="0.01" name="weight"
                               value="<?php echo $editData['weight'] ?? ''; ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Price (₹)</label>
                        <input type="number" step="0.01" name="price"
                               value="<?php echo $editData['price'] ?? ''; ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Quantity</label>
                        <input type="number" name="quantity"
                               value="<?php echo $editData['quantity'] ?? ''; ?>" required>
                    </div>

                    <button class="btn" name="<?php echo $editData ? 'update' : 'add'; ?>">
                        <?php echo $editData ? "Update Item" : "Add Item"; ?>
                    </button>
                </form>
            </div>

            <!-- TABLE -->
            <div class="table-wrapper">
                <h3>Available Stock</h3>

                <table>
                    <tr>
                        <th>#</th>
                        <th>Item</th>
                        <th>Category</th>
                        <th>Weight</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Action</th>
                    </tr>

                    <?php
                    $res = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($res)) {
                        echo "<tr>
                            <td>{$i}</td>
                            <td>{$row['item_name']}</td>
                            <td>{$row['category']}</td>
                            <td>{$row['weight']}</td>
                            <td>₹" . formatINR($row['price']) . "</td>
                            <td>{$row['quantity']}</td>
                            <td>
                                <a href='inventory.php?edit={$row['id']}' class='btn action-btn btn-edit'>Edit</a>
                                <a href='inventory.php?delete={$row['id']}'
                                   class='btn action-btn btn-delete'
                                   onclick=\"return confirm('Delete item?')\">Delete</a>
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
