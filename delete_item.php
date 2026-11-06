<?php
include "auth.php";
include "db.php";

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $stmt = mysqli_prepare($conn, "DELETE FROM items WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
}

header("Location: view_items.php");
exit();
?>