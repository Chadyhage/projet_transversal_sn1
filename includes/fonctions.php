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