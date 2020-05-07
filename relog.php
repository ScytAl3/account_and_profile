    <?php
    // On démarre la session
    session_start();

    // On détruit les variables de notre session uniquement pour garder les variables
    // de session concernant les messages d erreur : utilisateur a modifie son mot de passe
    // et doit se relogger
    unset($_SESSION['current']);

    // On redirige le visiteur vers la page login/index.php
    header('location: index.php');
    ?>