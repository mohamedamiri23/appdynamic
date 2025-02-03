<?php
session_start();

// Liste des produits (en dur)
$products = [
    1 => ['name' => 'Produit 1', 'description' => 'Description du produit 1', 'price' => 10, 'image' => 'https://via.placeholder.com/150'],
    2 => ['name' => 'Produit 2', 'description' => 'Description du produit 2', 'price' => 15, 'image' => 'https://via.placeholder.com/150'],
    3 => ['name' => 'Produit 3', 'description' => 'Description du produit 3', 'price' => 20, 'image' => 'https://via.placeholder.com/150']
];

// Ajouter un produit au panier
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    if (isset($products[$product_id])) {
        $_SESSION['cart'][$product_id] = $products[$product_id];
    }
}

// Supprimer un produit du panier
if (isset($_POST['remove_from_cart'])) {
    $product_id = $_POST['product_id'];
    unset($_SESSION['cart'][$product_id]);
}

// Vider le panier
if (isset($_POST['empty_cart'])) {
    unset($_SESSION['cart']);
}

// Calculer le total
$total = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'];
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boutique en ligne</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        h1 {
            text-align: center;
        }
        .products {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
        }
        .product {
            background-color: white;
            border: 1px solid #ddd;
            padding: 20px;
            margin: 10px;
            width: 200px;
            text-align: center;
        }
        .product img {
            width: 100%;
            height: auto;
        }
        .cart {
            margin-top: 20px;
            background-color: white;
            padding: 20px;
            border: 1px solid #ddd;
        }
        .cart ul {
            list-style-type: none;
            padding: 0;
        }
        .cart ul li {
            margin: 5px 0;
        }
        button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        .empty-cart {
            background-color: #dc3545;
        }
        .empty-cart:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <h1>Bienvenue dans notre boutique en ligne</h1>

    <div class="products">
        <?php foreach ($products as $id => $product): ?>
            <div class="product">
                <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                <h3><?php echo $product['name']; ?></h3>
                <p><?php echo $product['description']; ?></p>
                <p>Prix : <?php echo $product['price']; ?>€</p>
                <form action="" method="post">
                    <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                    <button type="submit" name="add_to_cart">Ajouter au panier</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="cart">
        <h2>Votre panier</h2>
        <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
            <ul>
                <?php foreach ($_SESSION['cart'] as $item): ?>
                    <li><?php echo $item['name']; ?> - <?php echo $item['price']; ?>€</li>
                <?php endforeach; ?>
            </ul>
            <p><strong>Total : <?php echo $total; ?>€</strong></p>
            <form action="" method="post">
                <button type="submit" name="empty_cart" class="empty-cart">Vider le panier</button>
            </form>
        <?php else: ?>
            <p>Votre panier est vide.</p>
        <?php endif; ?>
    </div>
</body>
</html>
