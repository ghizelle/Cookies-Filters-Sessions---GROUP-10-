<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Coffee Order</title>
    <link rel="stylesheet" href="styles.css">
    <script src="scripts.js" defer></script>
</head>
<body>
    <h1>Order Your Coffee</h1>
    
    <!-- Filter Form -->
    <form id="filterForm" method="get">
        <label for="type">Type:</label>
        <select name="type" id="type" onchange="this.form.submit()">
            <option value="">All Types</option>
            <option value="espresso" <?php if($type == 'espresso') echo 'selected'; ?>>Espresso</option>
            <option value="latte" <?php if($type == 'latte') echo 'selected'; ?>>Latte</option>
        </select>
        
        <label for="size">Size:</label>
        <select name="size" id="size" onchange="this.form.submit()">
            <option value="">All Sizes</option>
            <option value="small" <?php if($size == 'small') echo 'selected'; ?>>Small</option>
            <option value="medium" <?php if($size == 'medium') echo 'selected'; ?>>Medium</option>
            <option value="large" <?php if($size == 'large') echo 'selected'; ?>>Large</option>
        </select>

        <form method="post" action="add_to_cart.php">
    <input type="hidden" name="coffee_id" value="<?= $row['id'] ?>">
    <label for="quantity">Quantity:</label>
    <input type="number" name="quantity" value="1" min="1" required>
    <button type="submit">Add to Cart</button>
</form>

    </form>

    <!-- Coffee Products List -->
    <div id="productList">
        <?php while($row = $result->fetch_assoc()): ?>
            <div class="product">
                <h3><?= htmlspecialchars($row['name']) ?></h3>
                <p>Type: <?= htmlspecialchars($row['type']) ?>, Size: <?= htmlspecialchars($row['size']) ?></p>
                <p>Price: $<?= htmlspecialchars($row['price']) ?></p>
                <button onclick="addToCart(<?= $row['id'] ?>)">Add to Cart</button>
            </div>
        <?php endwhile; ?>
    </div>


    <!-- Link to Cart Page -->
     <footer="go-to-cart-container">
        <a href="cart.php" class="go-to-cart-button">Go to Cart</a>
        </footer>

        <div class="go-to-cart-container">
    <a href="cart.php" class="go-to-cart-button">Go to Cart</a>
</div>

</body>
</html>
