<?php
session_start();

// Assuming you store coffee details in the session or fetch them from the database for display purposes.
$cart_items = $_SESSION['cart'] ?? [];


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['coffee_id'])) {
    $coffee_id = $_POST['coffee_id'];
    $_SESSION['cart'][$coffee_id] = ($_SESSION['cart'][$coffee_id] ?? 0) + 1;
}

$cart_items = $_SESSION['cart'] ?? [];
?>

<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process checkout (e.g., save order to database)
    unset($_SESSION['cart']);  // Clear the cart after checkout
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Summary</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Order Summary</h1>


    <?php if (!empty($cart_items)): ?>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Type</th>
                    <th>Size</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart_items as $coffee_id => $quantity): ?>
                    <?php
                    // Fetch product details from the database
                    $query = "SELECT * FROM coffee_products WHERE id = $coffee_id";
                    $result = $conn->query($query);
                    $product = $result->fetch_assoc();

                    // Calculate subtotal
                    $subtotal = $product['price'] * $quantity;
                    $total_price += $subtotal;
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($product['name']) ?></td>
                        <td><?= htmlspecialchars($product['type']) ?></td>
                        <td><?= htmlspecialchars($product['size']) ?></td>
                        <td><?= $quantity ?></td>
                        <td>$<?= number_format($product['price'], 2) ?></td>
                        <td>$<?= number_format($subtotal, 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5">Total</th>
                    <th>$<?= number_format($total_price, 2) ?></th>
                </tr>
            </tfoot>
        </table>

        <p>Thank you for your order!</p>
        <a href="index.php">Back to Home</a>
    <?php else: ?>
        <p>Your cart is empty.</p>
        <a href="order.html">Continue Shopping</a>
    <?php endif; ?>

    <?php $conn->close(); ?>
</body>
</html>

