<?php
include('db1.php');

// Fetch orders from the database
$query = "SELECT * FROM orders";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #1e1e2f;
            margin: 0;
            padding: 0;
            color: #fff;
        }
        
        .container {
            width: 90%;
            max-width: 1100px;
            margin: 50px auto;
            background: #282a36;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        h2 {
            color: #f8f8f2;
            font-size: 26px;
            margin-bottom: 20px;
        }

        /* Back Button */
        .btn-back {
            display: inline-block;
            padding: 10px 15px;
            background: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background 0.3s;
        }

        .btn-back:hover {
            background: #0056b3;
        }

        /* Table Styles */
        .orders-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .orders-table thead {
            background: #007BFF;
            color: white;
        }

        .orders-table th, .orders-table td {
            padding: 12px;
            text-align: center;
            border: 1px solid #444;
        }

        .orders-table tbody tr {
            background: #44475a;
            transition: background 0.3s;
        }

        .orders-table tbody tr:hover {
            background: #6272a4;
        }

        /* Action Buttons */
        .actions a {
            display: inline-block;
            padding: 8px 12px;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
            margin: 3px;
            transition: 0.3s;
        }

        .btn-edit {
            background: #28a745;
            color: white;
        }

        .btn-edit:hover {
            background: #218838;
        }

        .btn-delete {
            background: #dc3545;
            color: white;
        }

        .btn-delete:hover {
            background: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>📦 Manage Orders</h2>
        
        <!-- Back to Admin Panel Button -->
        <a href="admin_panel.php" class="btn-back">⬅ Back to Admin Panel</a>
        
        <!-- Orders Table -->
        <table class="orders-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Payment Method</th>
                    <th>Order Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['product_name']; ?></td>
                        <td>₹<?php echo $row['price']; ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td>₹<?php echo $row['total_price']; ?></td>
                        <td><?php echo $row['payment_method']; ?></td>
                        <td><?php echo $row['order_date']; ?></td>
                        <td class="actions">
                            <a href="edit_order.php?id=<?php echo $row['id']; ?>" class="btn-edit">✏ Edit</a>
                            <a href="delete_order.php?id=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Are you sure?');">🗑 Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
