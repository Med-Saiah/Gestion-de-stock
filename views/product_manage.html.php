<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Produits</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<h2>Gestion des Produits</h2>

<?php if (isset($message) && $message): ?>
    <?= $message ?>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Catégorie</th>
            <th>Prix</th>
            <th>Quantité en Stock</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?= $product->name ?></td>
                <td><?= $product->category ?></td>
                <td><?= $product->price ?></td>
                <td><?= $product->stock_quantity ?></td>
                <td>
                    <a href="?edit=<?= $product->id ?>" class="edit-link">Modifier</a>
                    <a href="?delete=<?= $product->id ?>" class="delete-link" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit?');">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h3><?= $edit_mode ? 'Modifier le Produit' : 'Ajouter un Nouveau Produit' ?></h3>
<form method="POST">
    <?php if ($edit_mode && $edit_product): ?>
        <input type="hidden" name="product_id" value="<?= $edit_product->id ?>">
    <?php endif; ?>
    <input type="text" name="name" placeholder="Nom du Produit" value="<?= $edit_mode && $edit_product ? $edit_product->name : '' ?>" required>
    <input type="text" name="category" placeholder="Catégorie" value="<?= $edit_mode && $edit_product ? $edit_product->category : '' ?>" required>
    <input type="number" name="price" placeholder="Prix" value="<?= $edit_mode && $edit_product ? $edit_product->price : '' ?>" required>
    <input type="number" name="stock_quantity" placeholder="Quantité en Stock" value="<?= $edit_mode && $edit_product ? $edit_product->stock_quantity : '' ?>" required>
    <button type="submit" name="save_product">Enregistrer</button>
    <?php if ($edit_mode): ?>
        <button type="button" onclick="window.location.href='ProductController.php'">Annuler</button>
    <?php endif; ?>
    <button type="button" onclick="window.location.href='MainController.php'">Principale</button>
</form>
</body>
</html>