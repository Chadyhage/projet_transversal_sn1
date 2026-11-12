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
        'essais' => 0,
        'mot_entier' => false,
        'terminee' => false,
        'victoire' => 0,
        'points' => 0
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

// Le joueur propose une lettre (seulement si la partie n'est pas finie)
if (isset($_POST['lettre']) && $partie['terminee'] == false) {
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
}

// Le joueur propose un mot entier (seulement si la partie n'est pas finie)
if (isset($_POST['mot']) && $partie['terminee'] == false) {
    $propose = strtoupper(trim($_POST['mot']));

    if (!preg_match('/^[A-Z]+$/', $propose)) {
        $message = "Le mot doit contenir uniquement des lettres, sans accent ni espace.";
    } else {
        $partie['essais'] = $partie['essais'] + 1;

        if ($propose == $partie['mot']) {
            $partie['mot_entier'] = true;
        } else {
            $partie['vies'] = $partie['vies'] - 2;
            if ($partie['vies'] < 0) {
                $partie['vies'] = 0;
            }
            $message = $propose . " n'est pas le bon mot. Vous perdez deux vies.";
        }
    }
}

// Fin de partie : on vérifie si le joueur a gagné ou perdu
if ($partie['terminee'] == false) {
    // Il ne reste plus aucun _ dans le mot affiché : toutes les lettres sont trouvées
    $toutTrouve = strpos(motMasque($partie['mot'], $partie['lettres']), '_') === false;

    if ($partie['mot_entier'] || $toutTrouve) {
        $partie['terminee'] = true;
        $partie['victoire'] = 1;
    } elseif ($partie['vies'] == 0) {
        $partie['terminee'] = true;
        $partie['victoire'] = 0;
    }

    // La partie vient de se terminer : on calcule les points et on l'enregistre une seule fois
    if ($partie['terminee']) {
        $partie['points'] = calculerPoints($partie['niveau'], $partie['essais'], $partie['victoire'], $partie['mot_entier']);

        $requete = $dbh->prepare('INSERT INTO games (user_id, word_id, difficulty, attempts, victory, points) VALUES (?, ?, ?, ?, ?, ?)');
        $requete->execute(array($_SESSION['user_id'], $partie['id_mot'], $partie['niveau'], $partie['essais'], $partie['victoire'], $partie['points']));
    }
}

$_SESSION['partie'] = $partie;

include 'includes/header.php';
?>

<h1>Partie en cours</h1>

<?php
if ($message != '') {
    echo '<p>' . $message . '</p>';
}
?>

<p>Vies restantes : <?php echo $partie['vies']; ?></p>
<p>Essais : <?php echo $partie['essais']; ?></p>
<p>Lettres déjà testées : <?php echo implode(', ', $partie['lettres']); ?></p>

<?php if ($partie['terminee']) { ?>

    <p>Le mot était : <?php echo $partie['mot']; ?></p>

    <?php if ($partie['victoire'] == 1) { ?>
        <h2>Victoire !</h2>
        <p>Vous gagnez <?php echo $partie['points']; ?> points.</p>
    <?php } else { ?>
        <h2>Défaite</h2>
        <p>Vous perdez <?php echo -$partie['points']; ?> points.</p>
    <?php } ?>

    <a href="niveau.php">Nouvelle partie</a>
    <a href="index.php">Retour au menu</a>

<?php } else { ?>

    <p>Mot : <?php echo motMasque($partie['mot'], $partie['lettres']); ?></p>

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

    <form method="post" action="jeu.php">
        <label for="mot">Proposer le mot entier :</label>
        <input type="text" id="mot" name="mot" required>
        <button type="submit">Proposer</button>
    </form>

<?php } ?>

<?php include 'includes/footer.php'; ?>