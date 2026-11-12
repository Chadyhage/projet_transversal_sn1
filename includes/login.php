<?php
require_once 'config.php';
require_once 'includes/fonctions.php';

$message = '';

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];

    // On cherche le joueur avec cet email
    $requete = $dbh->prepare('SELECT id, pseudo, password FROM users WHERE email = ?');
    $requete->execute(array($email));
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);

    // Le joueur existe et le mot de passe correspond
    if (count($resultat) == 1 && password_verify($mdp, $resultat[0]['password'])) {
        $_SESSION['user_id'] = $resultat[0]['id'];
        $_SESSION['pseudo'] = $resultat[0]['pseudo'];
        header('Location: index.php');
        exit;
    } else {
        $message = "Email ou mot de passe incorrect.";
    }
}

include 'includes/header.php';
?>

<h1>Connexion</h1>

<?php
if ($message != '') {
    echo '<p>' . $message . '</p>';
}
?>

<form method="post" action="login.php">
    <label for="email">Adresse email</label>
    <input type="email" id="email" name="email" required>

    <label for="mdp">Mot de passe</label>
    <input type="password" id="mdp" name="mdp" required>

    <button type="submit">Se connecter</button>
</form>

<?php include 'includes/footer.php'; ?>