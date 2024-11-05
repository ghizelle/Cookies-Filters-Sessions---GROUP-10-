<?php
session_start();
$conn = new mysqli("localhost", "username", "password", "coffee_db");

$type = $_GET['type'] ?? '';
$size = $_GET['size'] ?? '';

$query = "SELECT * FROM coffee_products WHERE 1";
if ($type) $query .= " AND type = '$type'";
if ($size) $query .= " AND size = '$size'";

$result = $conn->query($query);
?>

<?php
session_start();

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
// Database connection
$conn = new mysqli("localhost", "username", "password", "coffee_db");

// Initialize total price
$total_price = 0;
?>
?>


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
        <button onclick="window.location.href='checkout.php'">Proceed to Checkout</button>
    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>
</body>
</html>


