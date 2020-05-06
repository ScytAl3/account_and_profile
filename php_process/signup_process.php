<!-- php treatment -->
<?php
// import pdo fonction sur la database
require '../pdo/pdo_db_functions.php';
// on demarre notre session 
session_start();
//
//var_dump($_POST);die;
//

// si le formulaire a ete soumis, verification de l existence des champs saisis
if (isset($_POST['lastName'], $_POST['firstName'], $_POST['birthDate'], $_POST['birthPlace'], $_POST['astrologicalSign'], $_POST['email'], $_POST['password'], $_POST['presentation'])) {
    // -------------------------------------------------------------------------------------------------
    //                      on verifie l existence d un utilisateur - condition email
    // -------------------------------------------------------------------------------------------------
    // condition de la recherce sql par email
    $whereEmail = 'email';
    // appelle de la fonction qui verifie si un utilisateur existe suivant la condition definie
    $emailTest = userExist($whereEmail, $_POST['email']);
    //
    // var_dump($emailTest); die;
    //
    // ---------------------------------------------------------------------------------
    //                                 si  - email exist
    // ---------------------------------------------------------------------------------
    if ($emailTest) {
        // on renvoie une message d erreur (email unique)
        $_SESSION['error']['page'] = 'signup';
        $_SESSION['error']['message'] = "Cette adresse mail est déjà associée à un compte !";
        // on redirige vers la page du formulaire d inscription
        header('location:/../sign_up.php');
        exit;
    }
    // ---------------------------------------------------------------------------------
    //                    verification de la saisie des champs obligatoires
    // ---------------------------------------------------------------------------------
    // verification format du nom
    if (!stringFormat($_POST['lastName'])) {
        // on renvoie une message d erreur (format nom)
        $_SESSION['error']['page'] = 'signup';
        $_SESSION['error']['message'] = "Nom: Commence par une majuscule - uniquement lettres, espace et trait d'union!";
        // on redirige vers la page du formulaire d inscription
        header('location:/../sign_up.php');
        exit;
    }

    // verification format du prenom
    if (!stringFormat($_POST['firstName'])) {
        // on renvoie une message d erreur (format prenom)
        $_SESSION['error']['page'] = 'signup';
        $_SESSION['error']['message'] = "Prénom: Commence par une majuscule - uniquement lettres, espace et trait d'union!";
        // on redirige vers la page du formulaire d inscription
        header('location:/../sign_up.php');
        exit;
    }

    // verification format du mail
    if (!mailFormat($_POST['email'])) {
        // on renvoie une message d erreur (format mail)
        $_SESSION['error']['page'] = 'signup';
        $_SESSION['error']['message'] = "Email: l'adresse mail doit être normalisée!";
        // on redirige vers la page du formulaire d inscription
        header('location:/../sign_up.php');
        exit;
    }

    // verification format du password
    if (!pwdFormat($_POST['password'])) {
        // on renvoie une message d erreur (format password)
        $_SESSION['error']['page'] = 'signup';
        $_SESSION['error']['message'] = "Password: de 12 caractères minimum contenant 1 majuscule, 1 chiffre et un caractère spécial!";
        // on redirige vers la page du formulaire d inscription
        header('location:/../sign_up.php');
        exit;
    }
    // ---------------------------------------------------------------------------------
    //                    verification de la saisie des champs optionnels
    // ---------------------------------------------------------------------------------
    // si une date de naissance a ete saisie
    if ($_POST['birthDate'] != '') {
        // on limite l age d inscription a 16 ans
        $dateNow = date("Y-m-d", strtotime("-16 years"));
        // si la date saisie est superieure a la limite on envoie un message d erreur
        if ($_POST['birthDate'] > $dateNow) {
            $_SESSION['error']['page'] = 'signup';
            $_SESSION['error']['message'] = "Date de naissance: vous devez avoir au moins 16 ans pour créer un compte!";
            // on redirige vers la page du formulaire d inscription
            header('location:/../sign_up.php');
            exit;
        }
    }
    // si un lieu de naissance a ete saisi
    if ($_POST['birthPlace'] != '') {
        // verification format du lieu de naissance
        if (!stringFormat($_POST['birthPlace'])) {
            // on renvoie une message d erreur (format lieu de naissance)
            $_SESSION['error']['page'] = 'signup';
            $_SESSION['error']['message'] = "Lieu de naissance: Commence par une majuscule - uniquement lettres, espace et trait d'union!";
            // on redirige vers la page du formulaire d inscription
            header('location:/../sign_up.php');
            exit;
        }
    }
    // -----------------------------------------------------------------------------------------------
    //          on creer le Salt et le mot de passe chiffre associes a ce nouvel utilisateur
    // -----------------------------------------------------------------------------------------------
    // creation du Salt
    $userSalt = generateSalt(10);
    // creation du mot de passe associe au Salt
    $userEncryptPwd = CreateEncryptedPassword($userSalt, $_POST['password']);
    // on recupere les informations saisies et le mot de passe chiffre dans un tableau 
    // si aucune date n a ete saisie on l a definie a null
    $dateOfBirth = ($_POST['birthDate'] != '') ? $_POST['birthDate'] : null;
    $userData = [
        $_POST['lastName'],
        $_POST['firstName'],
        $dateOfBirth,
        $_POST['birthPlace'],
        $_POST['astrologicalSign'],
        $_POST['email'],
        $userEncryptPwd,
        $userSalt,
        $_POST['presentation']
    ];
    // ---------------------------------------------------------------------------
    //                                  on creer l utilisateur
    // ---------------------------------------------------------------------------
    $newUser = createUser($userData);
    // ---------------------------------------------------------------------------------
    //                   si  - enregistrement s est bien deroule = new id
    // ---------------------------------------------------------------------------------
    if ($newUser > 0) {
        // on enregistre comme variables de session userName - le nom et le prenom concatene        
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $_SESSION['current']['userName'] = $firstName . ' ' . $lastName;
        // on enregistre comme variables de session - le role 
        $_SESSION['current']['userRole'] = 'ROLE_USER';
        // on enregistre comme variables de session - le numero d identifiant
        $_SESSION['current']['userId'] = $newUser;
        // on creer une variable de session login en cours
        $_SESSION['current']['login'] = true;
        // ---------------------------------------------------------------------------------
        //                       redirection vers la page de bienvenue
        // ---------------------------------------------------------------------------------
        header('location: /../welcome.php');
        exit();
        // ---------------------------------------------------------------------------------
        //                      sinon  - newUser = FALSE
        // --------------------------------------------------------------------------------- 
    } else {
        // on renvoie un message d erreur
        $_SESSION['error']['page'] = 'sign_up';
        $_SESSION['error']['message'] = "Problème lors de la création de votre compte !";
        // on redirige vers la page signup
        header('location:/../sign_up.php');
        exit();
    }
    // ---------------------------------------------------------------------------------
    //                      sinon  - probleme avec $_POST
    // ---------------------------------------------------------------------------------
} else {
    // on renvoie un message d erreur
    $_SESSION['error']['page'] = 'signup';
    $_SESSION['error']['message'] = "Il y a eu un problème lors de l'envoi de votre formulaire !";
    // on redirige vers la page signup
    header('location:/../sign_up.php');
    exit();
}


?>