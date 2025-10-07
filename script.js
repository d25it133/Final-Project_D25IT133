document.addEventListener("DOMContentLoaded", () => {
    fetchProducts();
    updateCartCount();

    // Attach event listener for search input
    document.getElementById("search").addEventListener("input", searchProducts);
});
document.addEventListener("click", function (event) {
    const target = event.target.closest(".product-link"); // Find closest `<a>` tag with product link
    if (target) {
        event.preventDefault(); // Prevent any conflicts
        window.location.href = target.href; // Force navigation
    }
});


let allProducts = []; // Store all products for search filtering

// Fetch Products from API or Backend
function fetchProducts() {
    fetch("http://localhost:5000/products")
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(products => {
            allProducts = products; // Store products globally for search
            displayProducts(products);
        })
        .catch(error => console.error("Error fetching products:", error));
}

// Function to display products dynamically
function displayProducts(products) {
    const productList = document.getElementById("product-list");

    if (!productList) {
        console.error("Error: 'product-list' element not found in HTML.");
        return;
    }

    productList.innerHTML = ""; // Clear previous content

    if (products.length === 0) {
        productList.innerHTML = "<p>No products found.</p>";
        return;
    }

    products.forEach(product => {
        const productCard = document.createElement("div");
        productCard.classList.add("product");

        productCard.innerHTML = `
            <a href="product_details.html?id=${product.id}" class="product-link">
                <img src="${product.image}" alt="${product.name}" class="product-image">
            </a>
            <h3>${product.name}</h3>
            <p>Price: ₹${product.price}</p>
            <button onclick="addToCart(${product.id}, '${product.name}', ${product.price})">Add to Cart</button>
        `;

        productList.appendChild(productCard);
    });
}

// Live Search Functionality
function searchProducts() {
    const searchText = document.getElementById("search").value.toLowerCase();

    const filteredProducts = allProducts.filter(product =>
        product.name.toLowerCase().includes(searchText)
    );

    displayProducts(filteredProducts);
}

// Add product to cart
function addToCart(id, name, price) {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    // Check if product is already in cart
    let existingItem = cart.find(item => item.id === id);
    if (existingItem) {
        alert("This item is already in your cart!");
        return;
    }

    cart.push({ id, name, price });
    localStorage.setItem("cart", JSON.stringify(cart));

    updateCartCount();
}

// Update cart count
function updateCartCount() {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    const cartCount = document.getElementById("cart-count");

    if (cartCount) {
        cartCount.innerText = cart.length;
    } else {
        console.error("Error: 'cart-count' element not found in HTML.");
    }
}
