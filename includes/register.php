<?php
require_once 'config.php';
require_once 'includes/fonctions.php';
include 'includes/header.php';
?>

<h1>Créer un compte</h1>

<form method="post" action="register.php">
    <label for="email">Adresse email</label>
    <input type="email" id="email" name="email" required>

    <label for="pseudo">Pseudo</label>
    <input type="text" id="pseudo" name="pseudo" maxlength="20" required>

    <label for="mdp">Mot de passe</label>
    <input type="password" id="mdp" name="mdp" required>
    <p>Au moins 12 caractères, avec une majuscule, une minuscule, un chiffre et un caractère spécial.</p>

    <label for="mdp2">Confirmer le mot de passe</label>
    <input type="password" id="mdp2" name="mdp2" required>

    <button type="submit">Créer mon compte</button>
</form>

<p>Déjà inscrit ? <a href="login.php">Se connecter</a></p>

<?php include 'includes/footer.php'; ?>