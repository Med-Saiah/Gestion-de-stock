<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Utilisateurs</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<h2>Gestion des Utilisateurs</h2>

<?php if (isset($message) && $message): ?>
    <?= $message ?>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Téléphone</th>
            <th>Nom d'utilisateur</th>
            <th>Rôle</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user->name ?></td>
                <td><?= $user->phone ?></td>
                <td><?= $user->username ?></td>
                <td><?= $user->role ?></td>
                <td>
                    <a href="?edit=<?= $user->id ?>" class="edit-link">Modifier</a>
                    <a href="?delete=<?= $user->id ?>" class="delete-link" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur?');">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h3><?= $edit_mode ? 'Modifier l\'Utilisateur' : 'Ajouter un Nouvel Utilisateur' ?></h3>
<form method="POST">
    <?php if ($edit_mode && $edit_user): ?>
        <input type="hidden" name="user_id" value="<?= $edit_user->id ?>">
    <?php endif; ?>
    <input type="text" name="name" placeholder="Nom" value="<?= $edit_mode && $edit_user ? $edit_user->name : '' ?>" required>
    <input type="text" name="phone" placeholder="Téléphone" value="<?= $edit_mode && $edit_user ? $edit_user->phone : '' ?>" required>
    <input type="text" name="username" placeholder="Nom d'utilisateur" value="<?= $edit_mode && $edit_user ? $edit_user->username : '' ?>" required>
    <input type="password" name="password" placeholder="Mot de passe" <?= $edit_mode ? '' : 'required' ?>>
    <select name="role">
        <option value="user" <?= $edit_mode && $edit_user && $edit_user->role === 'user' ? 'selected' : '' ?>>Utilisateur</option>
        <option value="admin" <?= $edit_mode && $edit_user && $edit_user->role === 'admin' ? 'selected' : '' ?>>Admin</option>
    </select>
    <button type="submit" name="save_user">Enregistrer</button>
    <?php if ($edit_mode): ?>
        <button type="button" onclick="window.location.href='UserController.php'">Annuler</button>
    <?php endif; ?>
    <button type="button" onclick="window.location.href='MainController.php'">Principale</button>
</form>
</body>
</html>