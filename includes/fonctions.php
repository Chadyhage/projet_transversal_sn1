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