<?php
require_once 'config.php';
require_once 'includes/fonctions.php';
exigerConnexion();
include 'includes/header.php';
?>

<h1>Règles du jeu</h1>

<h2>But du jeu</h2>
<p>Un mot est tiré au hasard selon le niveau choisi. Vous devez le trouver avant de perdre vos 7 vies.</p>

<h2>Les niveaux</h2>
<ul>
    <li>Facile : 2 lettres sont révélées au début de la partie.</li>
    <li>Moyen : 1 lettre est révélée.</li>
    <li>Difficile : aucune lettre n'est révélée.</li>
</ul>
<p>Une lettre révélée apparaît à toutes ses places dans le mot.</p>

<h2>À chaque tour</h2>
<ul>
    <li>Lettre correcte : elle apparaît partout où elle se trouve dans le mot.</li>
    <li>Lettre incorrecte : vous perdez 1 vie.</li>
    <li>Lettre déjà proposée : vous ne perdez rien.</li>
    <li>Mot entier correct : victoire immédiate avec un bonus.</li>
    <li>Mot entier incorrect : vous perdez 2 vies.</li>
</ul>
<p>Chaque nouvelle lettre et chaque mot proposé comptent comme un essai.</p>

<h2>Calcul des points</h2>
<p>En cas de victoire :</p>
<ul>
    <li>Points de base : 10 en facile, 20 en moyen, 30 en difficile.</li>
    <li>Bonus de rapidité : 15 moins le nombre d'essais (jamais négatif).</li>
    <li>Bonus mot entier : 10 points si vous avez deviné le mot entier.</li>
</ul>
<p>En cas de défaite : vous perdez 15 points en facile, 10 en moyen et 5 en difficile.</p>

<h2>Exemples</h2>
<ul>
    <li>Victoire en moyen en 9 essais, en proposant le mot : 20 + 6 + 10 = 36 points.</li>
    <li>Victoire en facile en 12 essais, lettre par lettre : 10 + 3 = 13 points.</li>
    <li>Défaite en difficile : -5 points.</li>
</ul>

<h2>Classement</h2>
<p>Le classement additionne les points de toutes vos parties, victoires et défaites comprises.</p>

<a href="niveau.php">Jouer une partie</a>

<?php include 'includes/footer.php'; ?>