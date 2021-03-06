<?php
// on démarre la session
session_start();
// import du script pdo des fonctions qui accedent a la base de donnees
require 'pdo/pdo_db_functions.php';
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
    $_SESSION['current']['userName'] = '';
    $_SESSION['current']['userId'] = '';
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
    <title>Compte avec profile | Login</title>
    <meta name="author" content="Franck Jakubowski">
    <meta name="description" content="Un site de login avec creation d'un compte et mise à jour du profil associé">
    <!--  favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon/favicon-16x16.png">
    <link rel="manifest" href="images/favicon/site.webmanifest">
    <link rel="mask-icon" href="images/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <!-- bootstrap stylesheet -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <!-- font awesome stylesheet -->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <!-- default stylesheet -->
    <link href="css/global.css" rel="stylesheet" type="text/css">
    <!-- current page stylesheet -->
    <link href="css/index.css" rel="stylesheet" type="text/css">
    <!-- font import -->
    <link href="https://fonts.googleapis.com/css?family=Oswald&display=swap" rel="stylesheet">
</head>

<body>
    <!-- import du header -->
    <?php include 'partials/header.php'; ?>
    <!-- /import du header -->

    <div class="container pt-3 mb-5">
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

            <!-- area pour afficher un message d erreur lors de la validation du login -->
            <div class="alert alert-danger <?= ($_SESSION['error']['message'] != '') ? 'd-block' : 'd-none'; ?> mt-5" role="alert">
                <p class="lead mt-2"><span><?= $_SESSION['error']['message'] ?></span></p>
            </div>
            <!-- /area pour afficher un message d erreur lors de la validation du login -->

            <form class="form-signin p-3" method="POST" action="php_process/login_process.php">
                <!-- email input -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input class="form-control fa fa-envelope" type="text" name="email" id="email" placeholder="&#xf0e0; Votre adresse email" required>
                </div>

                <!-- password input -->
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input class="form-control fa fa-key" type="password" name="password" id="password" placeholder="&#xf084; Password" required>
                    <a class="pull-right text-muted my-1" href="#"><small>Mot de passe oublié ?</small></a>
                </div>

                <!-- login button -->
                <div class="form-group mt-5">
                    <button class="btn btn-valid-gradient btn-lg btn-block text-light text-uppercase" type="submit">connexion</button>
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
                        <a class="btn btn-register-gradient btn-lg btn-block text-light text-uppercase" name="signup" role="button" href="sign_up.php">créer un compte</a>
                    </div>
                </div>
            </form>
        </div>
        <!---------------------- /formulaire de login ---------------------------->
        <!------------------------------------------------------------------------
                                    container global 
        --------------------------------//--------------------------------------->
    </div>

    <!-- import du footer -->
    <?php include 'partials/footer.php'; ?>
    <!-- /import du footer -->
    <!------------------------------------------>
    <?= var_dump($_SESSION) ?>
    <!------------------------------------------>
    <!-- import scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <!-- /import scripts -->
</body>

</html>