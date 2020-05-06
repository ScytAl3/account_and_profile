<!-- php treatment -->
<?php
// import pdo fonction sur la database
require '../pdo/pdo_db_functions.php';
// on demarre notre session 
session_start();

// si le formulaire a ete envoye on verifie si les variables existes
if (isset($_POST['email']) && isset($_POST['password'])) {
    // condition de la recherce sql par email
    $whereEmail = 'email';
    // appelle de la fonction qui verifie si un utilisateur existe suivant la condition definie
    $emailValid = userExist($whereEmail, $_POST['email']);
    //
    // var_dump($emailValid); die;
    //
    // ---------------------------------------------------------------------------------
    //                                       si  - email valid
    // ---------------------------------------------------------------------------------
    if ($emailValid) {
        // on appelle la fonction qui verifie le mot de passe saisi avec celui chiffre dans la base de donnees 
        $testPwd = validPassword($_POST['password'], $emailValid);
        //
        // var_dump($testPwd); die;
        //
        // ---------------------------------------------------------------------------------
        //                                  si  - password valid
        // ---------------------------------------------------------------------------------
        if ($testPwd) {
            // on enregistre comme variables de session userName - le nom et le prenom concatene        
            $firstName = $emailValid['firstName'];
            $lastName = $emailValid['lastName'];
            $_SESSION['current']['userName'] = $firstName . ' ' . $lastName;
            // on enregistre comme variables de session - le role 
            $_SESSION['current']['userRole'] = $emailValid['role'];
            // on enregistre comme variables de session - le numero d identifiant
            $_SESSION['current']['userId'] = $emailValid['id'];
            // on met a jour la variable de session login en cours
            $_SESSION['current']['login'] = true;
            // ---------------------------------------------------------------------------------
            //                       redirection vers la page de bienvenue
            // ---------------------------------------------------------------------------------
            header('location: /../welcome.php');
            exit();
            // ---------------------------------------------------------------------------------
            //                                  sinon  - password invalid
            // ---------------------------------------------------------------------------------
        } else {
            // on renvoie un message d erreur (mot de passe non valide)
            $_SESSION['error']['page'] = 'index';
            $_SESSION['error']['message'] = "Erreur de connexion, veuillez vérifier vos identifiants de connexion";
            // on redirige vers la page de login
            header('location:/../index.php');
            exit();
        }
        // ---------------------------------------------------------------------------------
        //                                       sinon  - email invalid
        // ---------------------------------------------------------------------------------  
    } else {
        // on renvoie un message d erreur (email n existe pas dans la table)
        $_SESSION['error']['page'] = 'index';
        $_SESSION['error']['message'] = "Erreur de connexion, veuillez vérifier vos identifiants de connexion";
        // on redirige vers la page de login
        header('location:/../index.php');
        exit();
    }
}
?>