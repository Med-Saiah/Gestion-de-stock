<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="../login.css">
</head>
<body>
    <div class="login-container">
        <h2>Connexion</h2>
        <?php if (isset($message) && $message): ?>
            <p class="message"><?= $message ?></p>
        <?php endif; ?>
        <form method="POST">
            <label for="username">Nom d'utilisateur</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>