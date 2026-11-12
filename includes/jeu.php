<?php
require_once 'config.php';
require_once 'includes/fonctions.php';
exigerConnexion();

// Nouvelle partie : le joueur vient de choisir un niveau
if (isset($_POST['niveau'])) {
    $niveau = $_POST['niveau'];

    // Le niveau doit être easy, medium ou hard
    if ($niveau != 'easy' && $niveau != 'medium' && $niveau != 'hard') {
        header('Location: niveau.php');
        exit;
    }

    // Tirage d'un mot au hasard dans ce niveau
    $requete = $dbh->prepare('SELECT id, word FROM words WHERE difficulty = ? ORDER BY RAND() LIMIT 1');
    $requete->execute(array($niveau));
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    $mot = $resultat[0]['word'];

    // Nombre de lettres révélées selon le niveau
    if ($niveau == 'easy') {
        $nbRevelees = 2;
    } elseif ($niveau == 'medium') {
        $nbRevelees = 1;
    } else {
        $nbRevelees = 0;
    }

    // On choisit au hasard des lettres différentes du mot
    $lettresDuMot = array_unique(str_split($mot));
    shuffle($lettresDuMot);
    $lettresRevelees = array_slice($lettresDuMot, 0, $nbRevelees);

    // La partie est gardée dans la session
    $_SESSION['partie'] = array(
        'id_mot' => $resultat[0]['id'],
        'mot' => $mot,
        'niveau' => $niveau,
        'lettres' => $lettresRevelees,
        'vies' => 7,
        'essais' => 0
    );

    header('Location: jeu.php');
    exit;
}

// Pas de partie en cours : retour au choix du niveau
if (!isset($_SESSION['partie'])) {
    header('Location: niveau.php');
    exit;
}

$partie = $_SESSION['partie'];

include 'includes/header.php';
?>

<h1>Partie en cours</h1>

<p>Mot : <?php echo motMasque($partie['mot'], $partie['lettres']); ?></p>
<p>Vies restantes : <?php echo $partie['vies']; ?></p>
<p>Lettres déjà testées : <?php echo implode(', ', $partie['lettres']); ?></p>

<?php include 'includes/footer.php'; ?>