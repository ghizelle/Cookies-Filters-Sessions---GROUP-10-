<?php
session_start();
$conn = new mysqli("localhost", "username", "password", "coffee_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get cart items from the session
$cart_items = $_SESSION['cart'] ?? [];

// Initialize total price
$total_price = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Your Cart</h1>

    <?php if (!empty($cart_items)): ?>
        <table class="cart-table">
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
                    // Fetch product details
                    $query = "SELECT * FROM coffee_products WHERE id = $coffee_id";
                    $result = $conn->query($query);
                    $product = $result->fetch_assoc();

                    // Calculate subtotal and total
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

        <a href="checkout.php" class="checkout-button">Proceed to Checkout</a>
    <?php else: ?>
        <p>Your cart is empty.</p>
        <a href="order.php" class="back-to-shop">Continue Shopping</a>
    <?php endif; ?>

    <?php $conn->close(); ?>
</body>
</html>
