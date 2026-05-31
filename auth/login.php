<?php
session_start();
include("../config/db.php");

$username = $_POST['username'];
$password = $_POST['password'];
$role     = $_POST['role'];

$q = "SELECT * FROM users
      WHERE username='$username'
      AND password='$password'
      AND role='$role'";

$res = mysqli_query($conn, $q);

if (mysqli_num_rows($res) === 1) {

    $user = mysqli_fetch_assoc($res);

    /* BLOCK INACTIVE STAFF */
    if ($role === 'staff' && $user['status'] !== 'active') {
        echo "<script>alert('Your account is disabled. Contact admin.');</script>";
        exit;
    }

    $_SESSION['user_id']  = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role']     = $user['role'];

    if ($role === 'admin') {
        header("Location: /jsms/admin/dashboard.php");
        exit;
    } else {
        header("Location: /jsms/staff/dashboard.php");
        exit;
    }

} else {
    echo "<script>alert('Invalid login');</script>";
}
