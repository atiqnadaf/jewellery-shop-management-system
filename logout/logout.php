<?php
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: ../index.php");
    exit;
}

/* Cancel = previous page */
$cancelUrl = $_SERVER['HTTP_REFERER'] ?? (
    $_SESSION['role'] === 'admin'
        ? "../admin/dashboard.php"
        : "../staff/dashboard.php"
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Logout | JSMS</title>
    <link rel="stylesheet" href="../assets/css/base.css">
    <style>
    body {
        margin: 0;
        font-family: "Segoe UI", sans-serif;
        background: linear-gradient(135deg, #DDE6ED, #9DB2BF);
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .logout-box {
        background: #ffffff;
        width: 420px;
        padding: 35px 30px;
        border-radius: 10px;
        text-align: center;
        box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        animation: fadeIn 0.4s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(15px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .logout-box h3 {
        margin: 0;
        margin-bottom: 10px;
        font-size: 20px;
        color: #27374D;
    }

    .logout-box p {
        font-size: 14px;
        color: #526D82;
        margin-bottom: 30px;
    }

    .logout-actions {
        display: flex;
        gap: 15px;
        justify-content: center;
    }

    .btn {
        flex: 1;
        padding: 12px 0;
        border-radius: 6px;
        font-size: 14px;
        text-decoration: none;
        transition: all 0.2s ease;
        font-weight: 500;
    }

    .btn-cancel {
        background: #DDE6ED;
        color: #27374D;
        border: 1px solid #9DB2BF;
    }

    .btn-cancel:hover {
        background: #9DB2BF;
        color: #ffffff;
    }

    .btn-logout {
        background: #27374D;
        color: #ffffff;
        border: none;
    }

    .btn-logout:hover {
        background: #526D82;
    }
</style>

</head>

<body>

<div class="logout-box">
    <h3>Are you sure you want to logout?</h3>

    <div class="logout-actions">
        <a href="<?php echo htmlspecialchars($cancelUrl); ?>" class="btn btn-cancel">Cancel</a>
        <a href="process.php" class="btn btn-logout">Logout</a>
    </div>
</div>

</body>
</html>
