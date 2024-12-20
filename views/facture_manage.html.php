<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Factures</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <h2>Gestion des Factures</h2>


<table>
    <thead>
        <tr>
            <th>Facture ID</th>
            <th>Utilisateur</th>
            <th>Client</th>
            <th>Total (DZD)</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($invoices as $invoice): ?>
            <tr>
                <td><?= $invoice->id ?></td>
                <td><?= $invoice->username ?></td>
                <td><?= $invoice->client_name ?></td>
                <td><?= $invoice->total ?></td>
                <td><?= $invoice->created_at ?></td>
                <td>
                    <a href="InvoiceViewController.php?id=<?= $invoice->id ?>" class="view-link">Voir</a>
                    <a href="?delete=<?= $invoice->id ?>" class="delete-link" onclick="return confirm('Are you sure you want to delete this invoice?');">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<button type="button" onclick="window.location.href='MainController.php'">Principale</button>
</body>
</html>