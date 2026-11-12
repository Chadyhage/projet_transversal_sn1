<?php
require_once 'config.php';
require_once 'includes/fonctions.php';
exigerConnexion();
include 'includes/header.php';
?>

<h1>Bonjour <?php echo proteger($_SESSION['pseudo']); ?></h1>
<p>Bienvenue sur le jeu du pendu.</p>

<a href="niveau.php">Nouvelle partie</a>
<a href="classement.php">Voir le classement</a>
<a href="regles.php">Règles du jeu</a>

<?php include 'includes/footer.php'; ?>