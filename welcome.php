<?php
// on démarre la session
session_start();
// import du script pdo des fonctions qui accedent a la base de donnees
require 'pdo/pdo_db_functions.php';
// verification que l utilisateur ne passe pas par l URL si le test a commence
if (isset($_SESSION['current']) && ($_SESSION['current']['login'] != true)) {
    header('location: index.php');
}
// ----------------------------//---------------------------
//                      variables de session
// ---------------------------------------------------------
//----------------------------//----------------------------
//                      CURRENT SESSION
// nom de la page en cours
$_SESSION['current']['page'] = 'welcome';
//                      CURRENT SESSION
//----------------------------//----------------------------
//----------------------------//----------------------------
//                     ERROR MANAGEMENT
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
    <title>Compte avec profile | Welcome</title>
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- font awesome stylesheet -->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <!-- default stylesheet -->
    <link href="css/global.css" rel="stylesheet" type="text/css">
    <!-- font import -->
    <link href="https://fonts.googleapis.com/css?family=Oswald&display=swap" rel="stylesheet">
</head>

<body>
    <!-- import du header -->
    <?php include 'partials/header.php'; ?>
    <!-- /import du header -->

    <div class="container global-padding-top pt-3 mb-5">
        <!------------------------------//----------------------------------------
                                    container global 
        ------------------------------------------------------------------------->
        <!-- message d information lors d une mise a jour du profil -->
        <div class="alert alert-info text-center <?= ($_SESSION['error']['message'] != '') ? 'd-block' : 'd-none'; ?>" role="alert">
            <p class="lead mt-2"><span><?= $_SESSION['error']['message'] ?></span></p>            
        </div>
        <!-- /message d information lors d une mise a jour du profil -->

        <!-- affiche un message de bienvenue -->
        <div class="my-3">
            <div class="mx-auto px-3 py-2 text-center info-message-bg">
                <h1 class="card-title">Welcome <?= $_SESSION['current']['userName'] ?> !</h1>
            </div>
        </div>
        <!-- /affiche un message de bienvenue -->

        <div class="col-lg-4 bg-light text-dark rounded mx-auto pb-3">
            <!-- update button -->
            <div class="form-group my-0">
                <a class="btn btn-success btn-circle btn-md mt-2" name="update" role="button" href="sign_up.php">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                </a>
            </div>

            <h3 class="text-center pb-3"><strong>Votre profil</strong></h3>

            <?php
            //-------------------------------------------------------------------
            // appelle de la fonction recuperer les informations du profil
            //-------------------------------------------------------------------
            // condition de la recherce sql par id
            $whereId = 'id';
            $myProfil = userExist($whereId, $_SESSION['current']['userId']);
            //
            // var_dump($myProfil);die;
            //
            ?>
            <!--------------------  information du profil ----------------------------->
            <ul class="list-group list-group-flush">
                <!-- lastName en majuscule -->
                <li class="list-group-item">
                    <p><small>Nom</small></p><?= strtoupper($myProfil['lastName']) ?>
                </li>

                <!-- firstName 1ere lettre en majusule -->
                <li class="list-group-item">
                    <p><small>Prénom</small></p><?= ucfirst($myProfil['firstName']) ?>
                </li>

                <!-- date of birth -->
                <li class="list-group-item">
                    <p><small>Date de naissance</small></p><?= formatedDateTime($myProfil['dateOfBirth']) ?>
                </li>

                <!-- place of birth 1ere lettre en majusule -->
                <li class="list-group-item">
                    <p><small>Lieu de naissance</small></p><?= ucfirst($myProfil['placeOfBirth']) ?>
                </li>

                <!-- astrological sign -->
                <li class="list-group-item">
                    <p><small>signe astrologique</small></p><?= $myProfil['astrological_sign'] ?>
                </li>

                <!-- email -->
                <li class="list-group-item">
                    <p><small>Email</small></p><?= $myProfil['email'] ?>
                </li>

                <!-- presentation tronquee a 200 caracteres -->
                <li class="list-group-item">
                    <p><small>Présentation</small></p><?= mb_strimwidth($myProfil['presentation'], 0, 200, '...') ?>
                </li>
            </ul>
        </div>
        <!--------------------  /information du profil ----------------------------->
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