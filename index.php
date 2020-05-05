<?php
// on démarre la session
session_start();
// import du script pdo des fonctions qui accedent a la base de donnees
require 'pdo/pdo_db_functions.php';
// verification que l utilisateur ne passe pas par l URL si le test a commence
if (isset($_SESSION['test']) && ($_SESSION['test']['start'])) {
    header('location: formation_questionnaire.php');
}
// ----------------------------//---------------------------
//                      variables de session
// ---------------------------------------------------------
//----------------------------//----------------------------s
//                       CURRENT SESSION
// on verifie l existence du tableau des informations de session, sinon on le cree
if (!isset($_SESSION['current'])) {
    // initialisation du tableau 
    $_SESSION['current'] = array();
    $_SESSION['current']['page'] = '';
    $_SESSION['current']['login'] = false;
    $_SESSION['current']['userId'] = time();
    $_SESSION['current']['userRole'] = 'Visitor';
}
// nom de la page en cours
$_SESSION['current']['page'] = 'index';
//                       CURRENT SESSION
//----------------------------//----------------------------
//----------------------------//----------------------------
//                     ERROR MANAGEMENT
// on verifie l existence du tableau d erreur, sinon on le cree
if (!isset($_SESSION['error'])) {
    // initialisation du tableau 
    $_SESSION['error'] = array();
    $_SESSION['error']['page'] = '';
    $_SESSION['error']['message'] = '';
}
// on efface le message d erreur d une autre page
if ($_SESSION['current']['page'] != $_SESSION['error']['page']) {
    $_SESSION['error']['message'] = '';
}
//                     ERROR MANAGEMENT
//----------------------------//----------------------------
// ----------------------------------------------------------
//                  variables de session
// ----------------------------//-----------------------------
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- default Meta -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compte avec profile</title>
    <meta name="author" content="Franck Jakubowski">
    <meta name="description" content="Un site de login avec creation d'un compte et mise à jour du profile associé">
    <!--  favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon/favicon-16x16.png">
    <link rel="manifest" href="images/favicon/site.webmanifest">
    <link rel="mask-icon" href="images/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <!-- bootstrap stylesheet -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- font awesome stylesheet -->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <!-- default stylesheet -->
    <link href="css/global.css" rel="stylesheet" type="text/css">
    <!-- page stylesheet -->
    <link href="css/index.css" rel="stylesheet" type="text/css">
    <!-- includes stylesheet -->
    <link href="css/header.css" rel="stylesheet" type="text/css">
    <link href="css/footer.css" rel="stylesheet" type="text/css">
    <!-- font import -->
    <link href="https://fonts.googleapis.com/css?family=Oswald&display=swap" rel="stylesheet">
</head>

<body>
    <!-- import du header -->
    <?php include 'partials/header.php'; ?>
    <!-- /import du header -->

    <div class="container global-padding-top pt-3 mb-5">
        <!-- message d information pour tester la connexion a la base de donnees -->
        <div class="alert alert-info text-center" role="alert">
            <?php require 'pdo/pdo_db_connect.php';
            // on instancie une connexion pour verifie s il n y a pas d erreurs avec les parametres de connexion
            $pdo = my_pdo_connexxion();
            if ($pdo) {
                echo 'Connexion réussie à la base de données';
            } else {
                var_dump($pdo);
            }
            ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <!-- /message d information pour tester la connexion a la base de donnees -->
        <!------------------------------//----------------------------------------
                                    container global 
        ------------------------------------------------------------------------->
        <!--------------------  formulaire de login ----------------------------->
        <div class="col-lg-4 bg-light text-dark rounded mx-auto">
            <h1 class="text-center py-3">Connexion</h1>
            <form class="form-signin p-3" method="POST" action="form_processing/login_process.php">
                <!-- email input -->
                <div class="form-group">
                    <label>Email</label>
                    <input class="form-control fa fa-envelope" type="text" name="email" id="email" placeholder="&#xf0e0; Votre adresse email" required autofocus="">
                </div>

                <!-- password input -->
                <div class="form-group">
                    <label>Mot de passe</label>
                    <input class="form-control fa fa-key" type="password" name="password" id="password" placeholder="&#xf084; Password" required>
                    <a class="pull-right text-muted my-1" href="#"><small>Mot de passe oublié ?</small></a>
                </div>

                <!-- login button -->
                <div class="form-group mt-5">
                    <button class="btn btn-bg-gradient btn-lg btn-block text-light text-uppercase" type="submit">connexion</button>
                    <!-- <a class="btn btn-primary btn-lg btn-block" name="signup" role="button" href="sign_up.php">SIGN UP</a> -->
                </div>
                <!-- separator -->
                <div class="media-seperator">
                    <b>ou</b>
                </div>
                <!-- connexion avec les medias sociaux -->
                <p class="text-center text-muted"><small>Connection avec votre compte</small></p>
                <div class="social-btn text-center">
                    <a href="#" class="btn btn-primary btn-lg" title="Facebook"><i class="fa fa-facebook"></i></a>
                    <a href="#" class="btn btn-info btn-lg" title="Twitter"><i class="fa fa-twitter"></i></a>
                    <a href="#" class="btn btn-danger btn-lg" title="Google"><i class="fa fa-google"></i></a>
                </div>
                <!-- enregistrer un compte -->
                <div class="media-seperator">
                    <h5 class="text-center text-muted mt-2"><small>Sinon créer un compte</small></h5>
                    <div class="form-group mt-3">
                        <a class="btn btn-primary btn-lg btn-block" name="signup" role="button" href="sign_up.php">créer un compte</a>
                    </div>
                </div>
            </form>
        </div>
        <!---------------------- /formulaire de login ---------------------------->
        <!------------------------------------------------------------------------
                                    container global 
        --------------------------------//--------------------------------------->
    </div>

    <!-- import du header -->
    <?php include 'partials/footer.php'; ?>
    <!-- /import du header -->
    <!------------------------------------------>
    <?= var_dump($_SESSION) ?>
    <!------------------------------------------>
    <!-- import scripts -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <!-- /import scripts -->
</body>

</html>