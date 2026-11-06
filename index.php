<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include "db.php";

// Dashboard statistics
$total = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS count FROM items")
)['count'];

$lost = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS count FROM items WHERE item_type='Lost'")
)['count'];

$found = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS count FROM items WHERE item_type='Found'")
)['count'];

$returned = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS count FROM items WHERE status='Returned'")
)['count'];

// Get latest 5 items
$recent = mysqli_query(
    $conn,
    "SELECT id, item_name, category, location, item_type, status
     FROM items ORDER BY id DESC LIMIT 5"
);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Campus Lost & Found Dashboard</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <h1>Campus Lost & Found Management System</h1>

    <p>
        Welcome,
        <?php echo htmlspecialchars($_SESSION['admin_username']); ?>!
        Manage lost and found items on your campus.
    </p>

    <h2>Dashboard Overview</h2>

    <!-- Dashboard Cards -->

    <div class="dashboard">

        <div class="card">
            <h3>Total Items</h3>
            <h2><?php echo $total; ?></h2>
        </div>

        <div class="card">
            <h3>Lost Items</h3>
            <h2><?php echo $lost; ?></h2>
        </div>

        <div class="card">
            <h3>Found Items</h3>
            <h2><?php echo $found; ?></h2>
        </div>

        <div class="card">
            <h3>Returned Items</h3>
            <h2><?php echo $returned; ?></h2>
        </div>

    </div>

    <!-- Navigation Buttons -->

    <div class="buttons">

        <a href="add_item.php">Report Lost / Found Item</a>

        <a href="view_items.php">View All Items</a>

        <a href="change_password.php">Change Password</a>

        <a href="logout.php">Logout</a>

    </div>

    <!-- Recent Items -->

    <h2>Recently Reported Items</h2>

    <table border="1" cellpadding="10" cellspacing="0" width="100%">

        <tr>
            <th>Item Name</th>
            <th>Category</th>
            <th>Location</th>
            <th>Type</th>
            <th>Status</th>
        </tr>

        <?php if (mysqli_num_rows($recent) > 0) { ?>

            <?php while ($row = mysqli_fetch_assoc($recent)) { ?>

                <tr>

                    <td><?php echo htmlspecialchars($row['item_name']); ?></td>

                    <td><?php echo htmlspecialchars($row['category']); ?></td>

                    <td><?php echo htmlspecialchars($row['location'] ?? ''); ?></td>

                    <td><?php echo htmlspecialchars($row['item_type']); ?></td>

                    <td><?php echo htmlspecialchars($row['status']); ?></td>

                </tr>

            <?php } ?>

        <?php } else { ?>

            <tr>
                <td colspan="5">No items reported yet.</td>
            </tr>

        <?php } ?>

    </table>

</div>

</body>
</html>