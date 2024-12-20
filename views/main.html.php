<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logiciel de Gestion de Stock</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <h2>Gestion de Stock - Facturation</h2>

<?php if (isset($message) && $message): ?>
    <?= $message ?>
<?php endif; ?>

<div id="admin-buttons" style="display: <?= $role === 'admin' ? 'block' : 'none' ?>;">
    <button onclick="window.location.href='UserController.php'">Gérer les Utilisateurs</button>
    <button onclick="window.location.href='ProductController.php'">Gérer les Produits</button>
    <button onclick="window.location.href='ClientController.php'">Gérer les Clients</button>
    <button onclick="window.location.href='FactureController.php'">Gestion des Factures</button>
</div>

<?php if (!isset($_SESSION['client_id'])): ?>
    <form method="POST">
        <label for="client_id">Client:</label>
        <select name="client_id" required>
            <option value="0">Choisir un client</option>
            <?php
                foreach ($clients as $client):
            ?>
                <option value="<?= $client->id ?>"><?= $client->name ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Sélectionner le Client</button>
    </form>
<?php endif; ?>

<?php if (isset($_SESSION['client_id'])): ?>
    <form method="POST" class="add-product-form">
        <label for="product_id">Produit:</label>
        <select name="product_id" required>
            <option>Choisissez un produit</option>
            <?php foreach ($products as $product): ?>
                <option value="<?= $product->id ?>"><?= $product->name ?></option>
            <?php endforeach; ?>
        </select>
        <label for="quantity">Quantité:</label>
        <input type="number" name="quantity" min="1" required>
        <button type="submit" name="add_to_cart">Ajouter</button>
    </form>
<?php endif; ?>

<h3>Produits Sélectionnés</h3>
<table>
    <thead>
        <tr>
            <th>Produit</th>
            <th>Prix Unitaire</th>
            <th>Quantité</th>
            <th>Sous-total</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if(isset($cart) && is_array($cart)) :
            foreach ($cart as $index => $item): ?>
            <tr>
                <td><?= $item['name'] ?></td>
                <td><?= $item['price'] ?> DZD</td>
                <td><?= $item['quantity'] ?></td>
                <td><?= $item['subtotal'] ?> DZD</td>
                <td>
                    <a href="?delete_from_cart=<?= $index ?>" class="delete-link">Supprimer</a>
                </td>
            </tr>
        <?php endforeach;
        endif; ?>
    </tbody>
</table>

<h3>Total: <?= isset($total) ? $total : '0' ?> DZD</h3>

<form method="POST">
    <button type="submit" name="save_facture">Enregistrer la Facture</button>
    <button type="submit" name="cancel_facture">Annuler la Facture</button>
        </br>
    <button type="submit" name="logout">Logout</button>
</form>
</body>
</html>