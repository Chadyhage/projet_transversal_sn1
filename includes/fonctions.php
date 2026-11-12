<?php
// Protège un texte avant de l'afficher dans la page (faille XSS)
function proteger($texte)
{
    return htmlspecialchars($texte, ENT_QUOTES, 'UTF-8');
}