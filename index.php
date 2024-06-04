<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background: url('https://www.thefolkadelics.com/wp-content/uploads/2022/11/6-Pairs-of-Shoes-Every-Woman-Needs.png') no-repeat center center fixed;
            background-size: cover;
            color: white;
        }
        .navbar {
            background: rgba(0, 0, 0, 0.8);
        }
        .navbar-brand span {
            color: #fff;
            font-weight: bold;
        }
        .form-inline .form-control {
            width: auto;
        }
        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
            width: 80%;
            margin: auto;
        }
        .card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
        }
        .card-img-top {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .card-body {
            text-align: center;
            color: black;
        }
        .card-title {
            font-size: 1.1em;
            font-weight: bold;
        }
        .price {
            font-size: 1.2em;
            color: black;
            font-weight: bold;
        }
        .btn-success {
            background-color: #28a745;
            border: none;
        }
        .btn-success:hover {
            background-color: #218838;
        }
        #cartContainer {
            position: fixed;
            top: 4em;
            right: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border: 1px solid #ddd;
            padding: 10px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
            z-index: 999;
            max-width: 200px;
            color: black;
        }
        .modal-content {
            color: black;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#">
            <img src="https://static.vecteezy.com/system/resources/previews/008/956/590/original/creative-abstract-black-silhouette-running-shoe-design-logo-design-template-free-vector.jpg" width="30" height="30" class="d-inline-block align-top" alt="Softball Logo">
            <span>cabz shoes Store</span>
        </a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <form class="form-inline my-2 my-lg-0 ml-auto">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>

    <div id="productsDisplay" class="card-grid"></div>
    <div id="cartContainer"></div>

    <div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Product Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalBody"></div>
                <div class="modal-footer">
                    <a id="paymentLink" class="btn btn-primary" href="#">Proceed to Payment</a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        fetch('./products/products-api.php')
            .then(response => response.json())
            .then(data => {
                const productsContainer = document.getElementById('productsDisplay');
                data.forEach(product => {
                    const cardHTML = `
                    <div class="card">
                        <img class="card-img-top" src="${product.img}">
                        <div class="card-body">
                            <h5 class="card-title">${product.title}</h5>
                            <span class="price">Price: ₱${product.rrp}</span>
                            <p class="card-text">${product.description}</p>
                            <p class="card-text">Quantity: ${product.quantity}</p>
                            <button class="btn btn-success" onclick="showProductModal('${product.title}', '${product.rrp}')">
                                <i class="fas fa-cart-plus"></i> Add to Cart
                            </button>
                        </div>
                    </div>`;
                    productsContainer.innerHTML += cardHTML;
                });
            })
            .catch(error => console.error('Error:', error));

        function showProductModal(title, price) {
            document.getElementById('modalBody').innerHTML = `
                <p>Name: ${title}</p>
                <p>Price: ₱${price}</p>`;
            document.getElementById('paymentLink').href = `it28-admin/payment_address/payment.php?productName=${encodeURIComponent(title)}&price=${encodeURIComponent(price)}`;
            $('#productModal').modal('show');
        }

        let cart = {};

        function addToCart(productId) {
            if (cart[productId]) {
                cart[productId]++;
            } else {
                cart[productId] = 1;
            }
            displayCart();
        }

        function displayCart() {
            const cartContainer = document.getElementById('cartContainer');
            let cartHTML = '<h3>Cart</h3>';
            for (const [productId, quantity] of Object.entries(cart)) {
                cartHTML += `<p>Product ID: ${productId}, Quantity: ${quantity}</p>`;
            }
            cartContainer.innerHTML = cartHTML;
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
