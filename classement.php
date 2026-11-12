<?php
require_once 'config.php';
require_once 'includes/fonctions.php';
exigerConnexion();

// Total des points de chaque joueur, du meilleur au moins bon
$requete = $dbh->prepare(
    'SELECT users.pseudo, SUM(games.points) AS total, COUNT(games.id) AS parties
     FROM users
     INNER JOIN games ON games.user_id = users.id
     GROUP BY users.id, users.pseudo
     ORDER BY total DESC
     LIMIT 10'
);
$requete->execute();
$joueurs = $requete->fetchAll(PDO::FETCH_ASSOC);

include 'includes/header.php';
?>

<h1>Classement</h1>

<?php if (count($joueurs) == 0) { ?>

    <p>Aucune partie n'a encore été jouée.</p>

<?php } else { ?>

    <table>
        <tr>
            <th>Rang</th>
            <th>Joueur</th>
            <th>Points</th>
            <th>Parties jouées</th>
        </tr>
        <?php
        $rang = 1;
        foreach ($joueurs as $joueur) {
            echo '<tr>';
            echo '<td>' . $rang . '</td>';
            echo '<td>' . proteger($joueur['pseudo']) . '</td>';
            echo '<td>' . $joueur['total'] . '</td>';
            echo '<td>' . $joueur['parties'] . '</td>';
            echo '</tr>';
            $rang = $rang + 1;
        }
        ?>
    </table>

<?php } ?>

<?php include 'includes/footer.php'; ?>