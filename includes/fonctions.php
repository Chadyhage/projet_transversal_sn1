<?php
// Protège un texte avant de l'afficher dans la page (faille XSS)
function proteger($texte)
{
    return htmlspecialchars($texte, ENT_QUOTES, 'UTF-8');
}

// Page réservée aux joueurs connectés
function exigerConnexion()
{
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
}

// Pages interdites aux joueurs déjà connectés (connexion, inscription)
function interdireSiConnecte()
{
    if (isset($_SESSION['user_id'])) {
        header('Location: index.php');
        exit;
    }
}
// Affiche le mot avec les lettres trouvées et des _ pour les autres
// Exemple : CROCODILE avec la lettre O -> _ _ O _ O _ _ _ _
function motMasque($mot, $lettres)
{
    $affichage = '';
    for ($i = 0; $i < strlen($mot); $i++) {
        if (in_array($mot[$i], $lettres)) {
            $affichage = $affichage . $mot[$i] . ' ';
        } else {
            $affichage = $affichage . '_ ';
        }
    }
    return $affichage;
}

// Calcule les points de fin de partie
function calculerPoints($niveau, $essais, $victoire, $motEntier)
{
    if ($victoire == 1) {
        if ($niveau == 'easy') {
            $points = 10;
        } elseif ($niveau == 'medium') {
            $points = 20;
        } else {
            $points = 30;
        }

        $bonus = 15 - $essais;
        if ($bonus < 0) {
            $bonus = 0;
        }
        $points = $points + $bonus;

        if ($motEntier) {
            $points = $points + 10;
        }
    } else {
        if ($niveau == 'easy') {
            $points = -15;
        } elseif ($niveau == 'medium') {
            $points = -10;
        } else {
            $points = -5;
        }
    }
    return $points;
}