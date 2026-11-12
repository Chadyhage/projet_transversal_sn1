   <?php
   session_start();

   try {
       $dbh = new PDO('mysql:host=localhost;dbname=pendu;charset=utf8mb4', 'root', '');
       $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   } catch (PDOException $e) {
       echo 'Erreur de connexion à la base de données.';
       exit;
   }