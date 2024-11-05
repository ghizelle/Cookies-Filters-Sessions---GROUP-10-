<?php
session_start();
$conn = new mysqli("localhost", "username", "password", "coffee_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get cart items from the session
$cart_items = $_SESSION['cart'] ?? [];

// Initialize total price
$total_price = 0;

// Calculate the total price and get details for each item
foreach ($cart_items as $coffee_id => $quantity) {
    $query = "SELECT price FROM coffee_products WHERE id = $coffee_id";
    $result = $conn->query($query);
    $product = $result->fetch_assoc();

    $subtotal = $product['price'] * $quantity;
    $total_price += $subtotal;
}

// Insert order into `orders` table
$stmt = $conn->prepare("INSERT INTO orders (user_id, total) VALUES (?, ?)");
$user_id = 1; // Example user ID; replace with actual user ID if applicable
$stmt->bind_param("id", $user_id, $total_price);
$stmt->execute();
$order_id = $stmt->insert_id; // Get the generated order ID

// Insert each item into `order_items` table
foreach ($cart_items as $coffee_id => $quantity) {
    $query = "SELECT price FROM coffee_products WHERE id = $coffee_id";
    $result = $conn->query($query);
    $product = $result->fetch_assoc();
    
    $price = $product['price'];
    $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiid", $order_id, $coffee_id, $quantity, $price);
    $stmt->execute();
}

// Clear cart from session after saving to database
unset($_SESSION['cart']);

echo "Order has been successfully placed!";
echo "<a href='cart.php?order_id=$order_id'>View Order Summary</a>";
$conn->close();
?>


<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Save order to database if needed
    unset($_SESSION['cart']);  // Clear the cart after checkout
    header("Location: index.php");
    exit;

    // After processing the checkout
unset($_SESSION['cart']);  // Clear the cart after checkout
header("Location: order_summary.php");
exit;

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link rel="stylesheet" href="styles.css">

</head>
<body>
    <h1>Checkout</h1>
    <form method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required>

        <label for="payment">Payment Method:</label>
        <select id="payment" name="payment">
            <option value="credit_card">Credit Card</option>
            <option value="cash_on_delivery">cash_on_delivery</option>
        </select>

        <button type="submit">Complete Order</button>
</form>
</body>
</html>
