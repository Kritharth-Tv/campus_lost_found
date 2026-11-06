<?php
include "auth.php";
include "db.php";

$message = "";

if (isset($_POST['change_password'])) {

    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    $admin_id = $_SESSION['admin_id'];

    // Get current admin password
    $stmt = mysqli_prepare(
        $conn,
        "SELECT password FROM admins WHERE id = ?"
    );

    mysqli_stmt_bind_param($stmt, "i", $admin_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $admin = mysqli_fetch_assoc($result);

    if (!password_verify($current_password, $admin['password'])) {

        $message = "Current password is incorrect!";

    } elseif (strlen($new_password) < 8) {

        $message = "New password must contain at least 8 characters!";

    } elseif ($new_password != $confirm_password) {

        $message = "New passwords do not match!";

    } else {

        $hashed_password = password_hash(
            $new_password,
            PASSWORD_DEFAULT
        );

        $update = mysqli_prepare(
            $conn,
            "UPDATE admins SET password = ? WHERE id = ?"
        );

        mysqli_stmt_bind_param(
            $update,
            "si",
            $hashed_password,
            $admin_id
        );

        if (mysqli_stmt_execute($update)) {
            $message = "Password changed successfully!";
        } else {
            $message = "Unable to change password!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Change Password</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <h1>Change Admin Password</h1>

    <p><?php echo htmlspecialchars($message); ?></p>

    <form method="POST">

        <label>Current Password:</label>
        <input type="password" name="current_password" required>

        <br><br>

        <label>New Password:</label>
        <input type="password" name="new_password"
               minlength="8" required>

        <br><br>

        <label>Confirm New Password:</label>
        <input type="password" name="confirm_password"
               minlength="8" required>

        <br><br>

        <button type="submit" name="change_password">
            Change Password
        </button>

    </form>

    <br>

    <a href="index.php">Back to Dashboard</a>

</div>

</body>
</html>