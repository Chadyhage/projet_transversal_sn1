<?php
require_once 'config.php';
require_once 'includes/fonctions.php';
exigerConnexion();

// Nouvelle partie : le joueur vient de choisir un niveau
if (isset($_POST['niveau'])) {
    $niveau = $_POST['niveau'];

    if ($niveau != 'easy' && $niveau != 'medium' && $niveau != 'hard') {
        header('Location: niveau.php');
        exit;
    }

    $requete = $dbh->prepare('SELECT id, word FROM words WHERE difficulty = ? ORDER BY RAND() LIMIT 1');
    $requete->execute(array($niveau));
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    $mot = $resultat[0]['word'];

    if ($niveau == 'easy') {
        $nbRevelees = 2;
    } elseif ($niveau == 'medium') {
        $nbRevelees = 1;
    } else {
        $nbRevelees = 0;
    }

    $lettresDuMot = array_unique(str_split($mot));
    shuffle($lettresDuMot);
    $lettresRevelees = array_slice($lettresDuMot, 0, $nbRevelees);

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

if (!isset($_SESSION['partie'])) {
    header('Location: niveau.php');
    exit;
}

$partie = $_SESSION['partie'];
$message = '';
'essais' => 0,
        'mot_entier' => false

// Le joueur propose une lettre
if (isset($_POST['lettre'])) {
    $lettre = strtoupper($_POST['lettre']);

    if (!preg_match('/^[A-Z]$/', $lettre)) {
        $message = "Proposez une seule lettre, de A à Z.";
    } elseif (in_array($lettre, $partie['lettres'])) {
        $message = "Vous avez déjà proposé la lettre " . $lettre . ".";
    } else {
        $partie['lettres'][] = $lettre;
        $partie['essais'] = $partie['essais'] + 1;

        if (strpos($partie['mot'], $lettre) === false) {
            $partie['vies'] = $partie['vies'] - 1;
            $message = "La lettre " . $lettre . " n'est pas dans le mot. Vous perdez une vie.";
        } else {
            $message = "Bien joué, la lettre " . $lettre . " est dans le mot.";
        }
    }

    $_SESSION['partie'] = $partie;
}
// Le joueur propose un mot entier
if (isset($_POST['mot'])) {
    $propose = strtoupper(trim($_POST['mot']));

    if (!preg_match('/^[A-Z]+$/', $propose)) {
        $message = "Le mot doit contenir uniquement des lettres, sans accent ni espace.";
    } else {
        $partie['essais'] = $partie['essais'] + 1;

        if ($propose == $partie['mot']) {
            $partie['mot_entier'] = true;
            $message = "Bravo, vous avez trouvé le mot !";
        } else {
            $partie['vies'] = $partie['vies'] - 2;
            if ($partie['vies'] < 0) {
                $partie['vies'] = 0;
            }
            $message = $propose . " n'est pas le bon mot. Vous perdez deux vies.";
        }
    }

    $_SESSION['partie'] = $partie;
}
include 'includes/header.php';
?>

<h1>Partie en cours</h1>

<?php
if ($message != '') {
    echo '<p>' . $message . '</p>';
}
?>

<p>Mot : <?php echo motMasque($partie['mot'], $partie['lettres']); ?></p>
<p>Vies restantes : <?php echo $partie['vies']; ?></p>
<p>Essais : <?php echo $partie['essais']; ?></p>
<p>Lettres déjà testées : <?php echo implode(', ', $partie['lettres']); ?></p>

<form method="post" action="jeu.php">
    <?php
    foreach (range('A', 'Z') as $l) {
        if (in_array($l, $partie['lettres'])) {
            echo '<button type="submit" name="lettre" value="' . $l . '" disabled>' . $l . '</button>';
        } else {
            echo '<button type="submit" name="lettre" value="' . $l . '">' . $l . '</button>';
        }
    }
    ?>
</form>

<?php include 'includes/footer.php'; ?>