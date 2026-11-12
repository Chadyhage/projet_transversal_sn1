<?php
require_once 'config.php';
require_once 'includes/fonctions.php';
exigerConnexion();
include 'includes/header.php';
?>

<h1>Nouvelle partie</h1>
<p>Choisissez un niveau :</p>

<form method="post" action="jeu.php">
    <button type="submit" name="niveau" value="easy">Facile</button>
    <button type="submit" name="niveau" value="medium">Moyen</button>
    <button type="submit" name="niveau" value="hard">Difficile</button>
</form>

<?php include 'includes/footer.php'; ?>