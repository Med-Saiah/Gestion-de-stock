<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Details</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <h2>Invoice Details</h2>


<h3>Facture ID: <?= $invoice->id ?></h3>
<p>Utilisateur: <?= $invoice->username ?></p>
<p>Client: <?= $invoice->client_name ?></p>
<p>Date: <?= $invoice->created_at ?></p>
<p>Total: <?= $invoice->total ?> DZD</p>

<h3>Produits</h3>
<table>
    <thead>
        <tr>
            <th>Produits</th>
            <th>Quantité</th>
            <th>Prix (DZD)</th>
            <th>Sous-total (DZD):</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?= $product->name ?></td>
                <td><?= $product->quantity ?></td>
                <td><?= $product->price ?></td>
                <td><?= $product->subtotal ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<button onclick="window.location.href='MainController.php'">Principale</button>
<button onclick="window.location.href='FactureController.php'">Retour</button>
</body>
</html>