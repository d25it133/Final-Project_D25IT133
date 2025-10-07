document.addEventListener("DOMContentLoaded", () => {
    loadProducts();
    loadOrders();
});

// Load Products from Local Storage
function loadProducts() {
    let products = JSON.parse(localStorage.getItem("products")) || [];
    let productList = document.getElementById("product-list");

    productList.innerHTML = "";
    products.forEach((product, index) => {
        let row = document.createElement("tr");
        row.innerHTML = `
            <td><img src="${product.image}" width="70"></td>
            <td>${product.name}</td>
            <td>₹${product.price}</td>
            <td>
                <button onclick="deleteProduct(${index})">Delete</button>
            </td>
        `;
        productList.appendChild(row);
    });
}

// Add New Product
document.getElementById("add-product-form").addEventListener("submit", function(event) {
    event.preventDefault();

    let name = document.getElementById("product-name").value;
    let price = document.getElementById("product-price").value;
    let image = document.getElementById("product-image").value;

    let products = JSON.parse(localStorage.getItem("products")) || [];
    products.push({ name, price, image });

    localStorage.setItem("products", JSON.stringify(products));
    loadProducts();
    alert("Product Added Successfully!");
    this.reset();
});

// Delete Product
function deleteProduct(index) {
    let products = JSON.parse(localStorage.getItem("products")) || [];
    products.splice(index, 1);
    localStorage.setItem("products", JSON.stringify(products));
    loadProducts();
}

// Load Orders
function loadOrders() {
    let orders = JSON.parse(localStorage.getItem("orders")) || [];
    let orderList = document.getElementById("order-list");

    orderList.innerHTML = "";
    orders.forEach((order, index) => {
        let row = document.createElement("tr");
        row.innerHTML = `
            <td>#${index + 1}</td>
            <td>${order.customerName}</td>
            <td>₹${order.totalPrice}</td>
            <td>${order.paymentMethod}</td>
            <td>${order.status}</td>
        `;
        orderList.appendChild(row);
    });
}

// Logout Admin
function logoutAdmin() {
    localStorage.removeItem("isAdminLoggedIn");
    alert("Logged out successfully!");
    window.location.href = "admin-login.html";
}
