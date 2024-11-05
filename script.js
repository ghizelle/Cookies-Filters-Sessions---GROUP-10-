function addToCart(coffeeId) {
    fetch('cart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `coffee_id=${coffeeId}`
    })
    .then(response => response.text())
    .then(data => {
        alert('Item added to cart!');
    });
}
document.querySelector(".go-to-cart-button").addEventListener("click", function () {
    alert("Redirecting to your cart...");
});
