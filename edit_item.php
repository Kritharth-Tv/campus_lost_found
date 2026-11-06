<?php
include "auth.php";
include "db.php";

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    die("Invalid item ID!");
}

$stmt = mysqli_prepare($conn, "SELECT * FROM items WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$item = mysqli_fetch_assoc($result);

if (!$item) {
    die("Item not found!");
}

if (isset($_POST['update'])) {

    $name = trim($_POST['item_name']);
    $category = trim($_POST['category']);
    $description = trim($_POST['description']);
    $location = trim($_POST['location']);
    $type = $_POST['item_type'];
    $date = $_POST['date_reported'];
    $status = $_POST['status'];
    $student_name = trim($_POST['student_name']);
    $contact_number = trim($_POST['contact_number']);

    $sql = "UPDATE items SET
            item_name = ?,
            category = ?,
            description = ?,
            location = ?,
            item_type = ?,
            date_reported = ?,
            status = ?,
            student_name = ?,
            contact_number = ?
            WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "sssssssssi",
        $name,
        $category,
        $description,
        $location,
        $type,
        $date,
        $status,
        $student_name,
        $contact_number,
        $id
    );

    if (mysqli_stmt_execute($stmt)) {
        header("Location: view_items.php");
        exit();
    } else {
        echo "Unable to update item.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Item</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <h1>Edit Item Details</h1>

    <form method="POST">

        <h3>Item Details</h3>

        <input type="text" name="item_name"
        value="<?php echo htmlspecialchars($item['item_name']); ?>" required><br><br>

        <input type="text" name="category"
        value="<?php echo htmlspecialchars($item['category']); ?>" required><br><br>

        <textarea name="description"><?php echo htmlspecialchars($item['description'] ?? ''); ?></textarea><br><br>

        <input type="text" name="location"
        value="<?php echo htmlspecialchars($item['location'] ?? ''); ?>"><br><br>

        <select name="item_type">
            <option value="Lost" <?php if($item['item_type']=="Lost") echo "selected"; ?>>Lost</option>
            <option value="Found" <?php if($item['item_type']=="Found") echo "selected"; ?>>Found</option>
        </select><br><br>

        <label>Date Reported:</label><br>

        <input type="date" name="date_reported"
        value="<?php echo htmlspecialchars($item['date_reported']); ?>" required><br><br>

        <h3>Student Details</h3>

        <input type="text" name="student_name"
        value="<?php echo htmlspecialchars($item['student_name']); ?>" required><br><br>

        <input type="tel" name="contact_number"
        value="<?php echo htmlspecialchars($item['contact_number']); ?>"
        pattern="[0-9]{10}" maxlength="10" required><br><br>

        <h3>Item Status</h3>

        <select name="status">
            <option value="Pending" <?php if($item['status']=="Pending") echo "selected"; ?>>Pending</option>
            <option value="Returned" <?php if($item['status']=="Returned") echo "selected"; ?>>Returned</option>
        </select><br><br>

        <button type="submit" name="update">Update Item</button>

    </form>

    <br>

    <a href="view_items.php">Back to Items</a>

</div>

</body>
</html>