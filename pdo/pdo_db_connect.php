<?php
// ------------------------------------------------------------
// Connexion à la base de données
// ------------------------------------------------------------
if( !function_exists('my_pdo_connexxion') ) {
    function my_pdo_connexxion()
    {
        // ---------
        $hostname    = 'localhost';             // voir hébergeur ou "localhost" en local
        $database    = 'db_account_profil_dev';      // nom de la BdD
        $username    = 'root';                    // identifiant "root" en local
        $password    = '';                           // mot de passe (vide en local)
        // ---------
        // connexion à la base de données
        try {
            // chaine de connexion (DSN)
            $strConn     = 'mysql:host='.$hostname.';dbname='.$database.';charset=utf8';    // UTF-8
            $extraParam    = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,                // rapport d'erreurs sous forme d'exceptions
                PDO::ATTR_PERSISTENT => true,                                                           // Connexions persistantes
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,     // fetch mode par defaut
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"         // encodage UTF-8
                );
            // Instancie la connexion
            $pdo = new PDO($strConn, $username, $password, $extraParam);
            return $pdo;
        }
        // ---------
        catch(PDOException $e){
            $msg = 'ERREUR PDO connexion...' . $e->getMessage(); die($msg);
            return false;
        }
        // ---------
    }
}
// --------------------------------------------------------------
//$pdo = my_pdo_connexxion();
// --------------------------------------------------------------