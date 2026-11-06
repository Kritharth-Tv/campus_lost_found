<?php
include "auth.php";
include "db.php";

// Search and filter values
$search = trim($_GET['search'] ?? '');
$type = $_GET['type'] ?? '';

// Main SQL query - excludes student name and contact number
$sql = "SELECT id, item_name, category, description, location,
        item_type, date_reported, status
        FROM items
        WHERE (
            item_name LIKE ?
            OR category LIKE ?
            OR location LIKE ?
        )";

$keyword = "%" . $search . "%";

// Apply Lost / Found filter
if ($type == "Lost" || $type == "Found") {
    $sql .= " AND item_type = ?";
}

$sql .= " ORDER BY id DESC";

// Prepare SQL statement
$stmt = mysqli_prepare($conn, $sql);

if ($type == "Lost" || $type == "Found") {
    mysqli_stmt_bind_param(
        $stmt,
        "ssss",
        $keyword,
        $keyword,
        $keyword,
        $type
    );
} else {
    mysqli_stmt_bind_param(
        $stmt,
        "sss",
        $keyword,
        $keyword,
        $keyword
    );
}

// Execute query
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>View Items - Campus Lost & Found</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <h1>All Lost & Found Items</h1>

    <!-- Lost and Found Filters -->

    <div class="buttons">

        <a href="view_items.php">All Items</a>

        <a href="view_items.php?type=Lost">Lost Items</a>

        <a href="view_items.php?type=Found">Found Items</a>

    </div>

    <br>

    <!-- Search Form -->

    <form method="GET">

        <?php if ($type == "Lost" || $type == "Found") { ?>

            <input type="hidden" name="type"
                   value="<?php echo htmlspecialchars($type); ?>">

        <?php } ?>

        <input
            type="text"
            name="search"
            placeholder="Search by item, category or location"
            value="<?php echo htmlspecialchars($search); ?>"
        >

        <button type="submit">Search</button>

        <a href="view_items.php">Show All</a>

    </form>

    <br>

    <!-- Items Table -->

    <table border="1" cellpadding="10" cellspacing="0" width="100%">

        <tr>

            <th>ID</th>
            <th>Item Name</th>
            <th>Category</th>
            <th>Description</th>
            <th>Location</th>
            <th>Type</th>
            <th>Date</th>
            <th>Status</th>
            <th>Actions</th>

        </tr>

        <?php if (mysqli_num_rows($result) > 0) { ?>

            <?php while ($row = mysqli_fetch_assoc($result)) { ?>

                <tr>

                    <td>
                        <?php echo (int)$row['id']; ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['item_name']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['category']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['description'] ?? ''); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['location'] ?? ''); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['item_type']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['date_reported']); ?>
                    </td>

                    <td>

                        <?php echo htmlspecialchars($row['status']); ?>

                        <?php if ($row['status'] != 'Returned') { ?>

                            <br><br>

                            <a href="return_item.php?id=<?php echo (int)$row['id']; ?>">
                                Mark as Returned
                            </a>

                        <?php } ?>

                    </td>

                    <td>

                        <a href="edit_item.php?id=<?php echo (int)$row['id']; ?>">
                            Edit
                        </a>

                        <a href="delete_item.php?id=<?php echo (int)$row['id']; ?>"
                           onclick="return confirm('Are you sure you want to delete this item?')">
                            Delete
                        </a>

                    </td>

                </tr>

            <?php } ?>

        <?php } else { ?>

            <tr>

                <td colspan="9">
                    No items found!
                </td>

            </tr>

        <?php } ?>

    </table>

    <br>

    <a href="add_item.php">Add New Item</a>

    <a href="index.php">Back to Home</a>

</div>

</body>

</html>

<?php
mysqli_stmt_close($stmt);
?>