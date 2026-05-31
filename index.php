<!DOCTYPE html>
<html>

<head>
    <title>Jewellery Shop Management System</title>
    <link rel="stylesheet" href="assets/css/base.css">
    <link rel="stylesheet" href="assets/css/login.css">
</head>

<body>

    <div class="login-wrapper">
        <div class="login-card">
            <h2>Jewellery Shop Management System</h2>

            <form action="auth/login.php" method="post">

                <!-- Username -->
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" required>
                </div>

                <!-- Password -->
                <div class="form-group password-box">
                    <label>Password</label>
                    <input type="password" name="password" id="password" required>
                    <span class="toggle-password" onclick="togglePassword()">Show</span>
                </div>

                <!-- Role -->
                <div class="form-group role-group role-buttons">
                    <label class="role-btn">
                        <input type="radio" name="role" value="admin" required>
                        <span>Admin</span>
                    </label>

                    <label class="role-btn">
                        <input type="radio" name="role" value="staff">
                        <span>Staff</span>
                    </label>
                </div>


                <!-- Login Button -->
                <button type="submit" class="btn login-btn">Login</button>

            </form>
        </div>
    </div>

    <script>
        function togglePassword() {
            const pwd = document.getElementById("password");
            const toggle = document.querySelector(".toggle-password");

            if (pwd.type === "password") {
                pwd.type = "text";
                toggle.innerText = "Hide";
            } else {
                pwd.type = "password";
                toggle.innerText = "Show";
            }
        }
    </script>

</body>

</html>