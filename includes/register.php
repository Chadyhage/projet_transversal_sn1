<?php
require_once 'config.php';
require_once 'includes/fonctions.php';

$message = '';

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $pseudo = $_POST['pseudo'];
    $mdp = $_POST['mdp'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "L'adresse email n'est pas valide.";
    } elseif ($pseudo == '') {
        $message = "Le pseudo est obligatoire.";
    } elseif (strlen($mdp) < 12) {
        $message = "Le mot de passe doit contenir au moins 12 caractères.";
    } elseif (!preg_match('/[A-Z]/', $mdp) || !preg_match('/[a-z]/', $mdp) || !preg_match('/[0-9]/', $mdp) || !preg_match('/[^A-Za-z0-9]/', $mdp)) {
        $message = "Le mot de passe doit contenir une majuscule, une minuscule, un chiffre et un caractère spécial.";
    }
}

include 'includes/header.php';
?>

<h1>Créer un compte</h1>

<?php
if ($message != '') {
    echo '<p>' . $message . '</p>';
}
?>

<form method="post" action="register.php">
    <label for="email">Adresse email</label>
    <input type="email" id="email" name="email" required>

    <label for="pseudo">Pseudo</label>
    <input type="text" id="pseudo" name="pseudo" maxlength="20" required>

    <label for="mdp">Mot de passe</label>
    <input type="password" id="mdp" name="mdp" required>

    <button type="submit">Créer mon compte</button>
</form>

<?php include 'includes/footer.php'; ?>