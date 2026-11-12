   <!DOCTYPE html>
   <html lang="fr">
   <head>
       <meta charset="UTF-8">
       <meta name="viewport" content="width=device-width, initial-scale=1">
       <title>Jeu du pendu</title>
       <link rel="stylesheet" href="Style/index.css">
   </head>
   <body>
       <div id="logo">Jeu du pendu</div>
       <div class="btn_header">
           <?php if (isset($_SESSION['user_id'])) { ?>
               <a href="index.php">Accueil</a>
               <a href="niveau.php">Jouer</a>
               <a href="classement.php">Classement</a>
               <a href="regles.php">Règles du jeu</a>
               <a href="logout.php">Déconnexion</a>
           <?php } else { ?>
               <a href="login.php">J'ai un compte</a>
               <a href="register.php">Créer un compte</a>
           <?php } ?>
       </div>