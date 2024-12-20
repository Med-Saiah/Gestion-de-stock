<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Clients</title>
     <link rel="stylesheet" href="../style.css">
</head>
<body>
<h2>Gestion des Clients</h2>

<?php if (isset($message) && $message): ?>
    <?= $message ?>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Téléphone</th>
            <th>Nombre d'Achats</th>
            <th>Total Dépensé</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($clients as $client): ?>
            <tr>
                <td><?= $client->name ?></td>
                <td><?= $client->phone ?></td>
                <td><?= $client->number_of_purchases ?></td>
                <td><?= $client->total_spent ?></td>
                <td>
                    <a href="?edit=<?= $client->id ?>" class="edit-link">Modifier</a>
                    <a href="?delete=<?= $client->id ?>" class="delete-link" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce client?');">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h3><?= $edit_mode ? 'Modifier le Client' : 'Ajouter un Nouveau Client' ?></h3>
<form method="POST">
    <?php if ($edit_mode && $edit_client): ?>
        <input type="hidden" name="client_id" value="<?= $edit_client->id ?>">
    <?php endif; ?>
    <input type="text" name="name" placeholder="Nom du Client" value="<?= $edit_mode && $edit_client ? $edit_client->name : '' ?>" required>
    <input type="text" name="phone" placeholder="Téléphone du Client" value="<?= $edit_mode && $edit_client ? $edit_client->phone : '' ?>" required>
    <button type="submit" name="save_client">Enregistrer</button>
    <?php if ($edit_mode): ?>
        <button type="button" onclick="window.location.href='ClientController.php'">Annuler</button>
    <?php endif; ?>
      <button type="button" onclick="window.location.href='MainController.php'">Principale</button>
</form>
</body>
</html>