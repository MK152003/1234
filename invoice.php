<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            background-color: aliceblue;
        }

        th {
            background-color: #f2f2f2;
        }

        .search-container {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<h2>Invoice</h2>

<div class="search-container">
    <form action="invoice.php" method="post">
        <label for="search">Search:</label>
        <input type="text" id="search" name="search" placeholder="">
        <button type="submit">Search</button>
    </form>
</div>

<table>
    <thead>
        <tr>
            <th>Invoice Number</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>

<?php
include 'connection.php';

// Check if the form is submitted with a search term
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $searchTerm = trim($_POST['search']);
    $searchTerm = mysqli_real_escape_string($conn, $searchTerm); // Sanitize the input
    $sql = "SELECT * FROM invoices WHERE 
            LOWER(invoice_num) LIKE LOWER('%$searchTerm%') OR 
            LOWER(name) LIKE LOWER('%$searchTerm%') OR 
            phone LIKE '%$searchTerm%'";
} else {
    // If no search term, fetch all invoices
    $sql = "SELECT * FROM invoices";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['invoice_num'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['phone'] . "</td>";
        echo "<td>" . $row['address'] . "</td>";
        echo "<td><form action='download.php' method='post'>";
        echo "<input type='hidden' name='invoiceId' value='" . $row['id'] . "'>";
        echo "<button type='submit'>Download</button></form></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>No invoices found</td></tr>";
}

$conn->close();
?>
    </tbody>
</table>

</body>
</html>
