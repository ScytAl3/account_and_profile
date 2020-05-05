<?php
// on démarre la session
session_start ();
// import du script pdo des fonctions qui accedent a la base de donnees
require 'pdo/pdo_db_functions.php';
// verification que l utilisateur ne passe pas par l URL si le test a commence
if(isset($_SESSION['test']) && ($_SESSION['test']['start'])) {
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
if ($_SESSION['current']['page'] != $_SESSION['error']['page']) {$_SESSION['error']['message'] = '';}
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
		<!--  
            favicons 
            -->
		<!-- bootstrap stylesheet -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
            integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <!-- font awesome stylesheet -->
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
		<!-- default stylesheet -->
        <link href="css/global.css" rel="stylesheet" type="text/css">
        <!-- page stylesheet -->
		<link href="css/index.css" rel="stylesheet" type="text/css">
        <!-- includes stylesheet -->
        <link href="css/header.css" rel="stylesheet" type="text/css">
        <link href="css/footer.css" rel="stylesheet" type="text/css">
    </head>    
    
	<body class="bg-white">   
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
            <!-----------------------------------------------//---------------------------------------------------
                                container global pour afficher le formulaire de connexion
            ----------------------------------------------------------------------------------------------------->           
            <!-- titre de la page du dossier de candidature -->
            <div class="py-5 text-center">
                <h1 class="display-4 font-weight-bold text-uppercase">Dossier de candidature</h1>             
                <!-- area pour afficher un message d erreur lors de la validation du dossier de candidature -->
                <div class="alert alert-danger <?=($_SESSION['error']['message'] != '') ? 'd-block' : 'd-none'; ?> mt-5" role="alert">
                    <p class="lead mt-2"><span><?=$_SESSION['error']['message'] ?></span></p>
                </div>
                <!-- /area pour afficher un message d erreur lors de la validation du dossier de candidature -->   
            </div>
            <!-- /titre de la page du dossier de candidature -->                 
            <!--------------------  formulaire pour le dossier du candidat ----------------------------->
            
            <!---------------------- /formulaire pour le dossier du candidat ---------------------------->        
            <!--------------------------------------//-------------------------------------------------------------
                            /container global pour afficher le formulaire pour le dossier du candidat
            -------------------------------------------------//---------------------------------------------------->   
        </div>

        <!-- import du header -->
        <?php include 'partials/footer.php'; ?>
        <!-- /import du header -->
<!------------------------------------------>
    <?=var_dump($_SESSION) ?>
<!------------------------------------------>
        <!-- import scripts -->
		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
			integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
			crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
			integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
			crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
			integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
			crossorigin="anonymous"></script>
		<!-- /import scripts -->
	</body>
</html>
