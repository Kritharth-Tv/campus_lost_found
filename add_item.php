<?php
include "auth.php";
include "db.php";

if (isset($_POST['submit'])) {

    $item_name = trim($_POST['item_name']);
    $category = trim($_POST['category']);
    $description = trim($_POST['description']);
    $location = trim($_POST['location']);
    $item_type = $_POST['item_type'];
    $date_reported = $_POST['date_reported'];
    $student_name = trim($_POST['student_name']);
    $contact_number = trim($_POST['contact_number']);

    $sql = "INSERT INTO items
    (item_name, category, description, location, item_type,
    date_reported, student_name, contact_number)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "ssssssss",
        $item_name,
        $category,
        $description,
        $location,
        $item_type,
        $date_reported,
        $student_name,
        $contact_number
    );

    if (mysqli_stmt_execute($stmt)) {

        echo "<script>
        alert('Item reported successfully!');
        window.location='view_items.php';
        </script>";

        exit();

    } else {

        echo "Error: " . mysqli_error($conn);

    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Report Item - Campus Lost & Found</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <h1>Report Lost / Found Item</h1>

    <form method="POST">

        <h3>Item Details</h3>

        <input type="text" name="item_name"
               placeholder="Item Name" required><br><br>

        <select name="category" required>
            <option value="">Select Category</option>
            <option value="Electronics">Electronics</option>
            <option value="Books">Books</option>
            <option value="Accessories">Accessories</option>
            <option value="Documents">Documents</option>
            <option value="Other">Other</option>
        </select><br><br>

        <textarea name="description"
                  placeholder="Describe the item"></textarea><br><br>

        <input type="text" name="location"
               placeholder="Where was it lost or found?"><br><br>

        <select name="item_type" required>
            <option value="">Select Report Type</option>
            <option value="Lost">Lost</option>
            <option value="Found">Found</option>
        </select><br><br>

        <label>Date Reported:</label><br>

        <input type="date" name="date_reported" required><br><br>

        <h3>Student Details</h3>

        <input type="text" name="student_name"
               placeholder="Student Name" required><br><br>

        <input type="tel" name="contact_number"
               placeholder="Contact Number"
               pattern="[0-9]{10}"
               maxlength="10"
               title="Enter a 10-digit phone number"
               required><br><br>

        <button type="submit" name="submit">
            Submit Report
        </button>

    </form>

    <br>

    <a href="index.php">Back to Home</a>

</div>

</body>
</html>