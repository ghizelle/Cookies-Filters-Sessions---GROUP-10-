<?php
session_start();

// Check if a product ID was submitted
if (isset($_POST['coffee_id'])) {
    $coffee_id = $_POST['coffee_id'];
    
    // Initialize the cart in the session if it doesn't already exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    // Add item to cart or increase quantity
    if (isset($_SESSION['cart'][$coffee_id])) {
        $_SESSION['cart'][$coffee_id]++;
    } else {
        $_SESSION['cart'][$coffee_id] = 1;
    }
}

// Redirect back to the order page
header("Location: cart.php");
exit;


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cart</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Your Cart</h1>
    <?php if (!empty($cart_items)): ?>
        <ul>
            <?php foreach ($cart_items as $coffee_id => $quantity): ?>
                <li>Product ID: <?= $coffee_id ?> | Quantity: <?= $quantity ?></li>
            <?php endforeach; ?>
        </ul>
        <a href= "checkout.php">Proceed to Checkout</button>
    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>
</body>
</html>
