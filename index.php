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
//----------------------------//----------------------------
//                     QUESTIONNAIRE
// on verifie l existence du test, sinon on le cree
if (!isset($_SESSION['test'])) {
    // initialisation du test 
    $_SESSION['test'] = array();
    // subdivision du test 
    $_SESSION['test']['id_formation'] = "";
    $_SESSION['test']['id_questionnaire'] = "";
    $_SESSION['test']['start'] = false;
    $_SESSION['test']['time_debut'] = "";
    $_SESSION['test']['end'] = false;
    $_SESSION['test']['id_question'] = array();
    $_SESSION['test']['reponse'] = array();
}
//                      QUESTIONNAIRE
//----------------------------//----------------------------
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
// jauge de la barre de progression
$_SESSION['current']['progressbar'] = 0;

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
		<title>CCI Formation - Dossier de candidature</title>
		<meta name="author" content="Franck Jakubowski">
		<meta name="description" content="Un site pour que les futurs candidats puissent passer le test correspondant à la formation qu'ils veulent suivre après avoir rempli un formulaire de renseignements">
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
        <?php include 'includes/header.php'; ?>
        <!-- /import du header -->
        <?php
            /*$before = time();
            $dateBefore = date('Y-m-d H:i:s', $before);
            echo $dateBefore.'<br>';
            $after = time();
            date_default_timezone_set("Europe/Paris");
            
            $dateAfter = date('Y-m-d H:i:s', $after);
            echo $dateAfter.'<br>';*/
        ?>
        
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
                                container global pour afficher le formulaire pour le dossier du candidat
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
            <form class="<?=($_SESSION['current']['login']) ? 'd-none' : 'd-block'; ?>" action="php_process/candidature_form_process.php" method="POST">
                <!-----------------------------------------------//---------------------------------------------------
                                                                            etat civil
                ----------------------------------------------------------------------------------------------------->
                <div class="col-md-12 px-0">
                    <h4 class="p-3 mb-4 bg-info text-white text-uppercase">Votre état civil</h4>
                    <!-- nom & prenom -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="lastName">Nom</label>
                            <input type="text" class="form-control" id="lastName" name ="lastName" placeholder="" value="" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="firstName">Prénom</label>
                            <input type="text" class="form-control" id="firstName" name ="firstName" placeholder="" value="" required>
                        </div>
                    </div>
                    <!-- /nom & prenom -->

                    <!-- nom jeune fille & date naissance -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="maidenSurname">Nom de jeune fille</label>
                            <input type="text" class="form-control" id="maidenSurname" name ="maidenSurname" placeholder="" value="">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="birthDate">Date de naissance</label>
                            <input type="date" class="form-control" id="birthDate"  name ="birthDate" placeholder="" value="" required>
                        </div>
                    </div>
                    <!-- /nom jeune fille & date naissance -->

                    <!-- numero securite sociale -->
                    <div class="mb-3">
                        <label for="socialSecurityNumber">N° de sécurité sociale</label>
                        <input type="text" class="form-control" id="socialSecurityNumber" name="socialSecurityNumber" placeholder="15 chiffres ex : 1 85 05 78 006 084 36" value="" required>
                    </div>
                    <!-- /numero securite sociale -->

                    <!-- lieu de naissance et code postal -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="birthPlace">Lieu de naissance</label>
                            <input type="text" class="form-control" id="birthPlace" name ="birthPlace" placeholder="" value="" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="birthDepartment">Département</label>
                            <input type="text" class="form-control" id="birthDepartment" name ="birthDepartment" placeholder="" value="" required>
                        </div>
                    </div>
                    <!-- /lieu de naissance et code postal -->

                    <!-- nationalite -->
                    <div class="mb-3">
                        <label for="nationality">Nationalié</label>
                        <input type="text" class="form-control" id="nationality" name="nationality" placeholder="" value="" required>
                    </div>
                    <!-- /nationalite -->

                    <!-- permis de conduire -->
                    <div class="mb-3">
                        <label class="col-md-3" for="radioLicencse">Permis de conduire</label>
                        <div class="form-check form-check-inline ml-5">
                            <input class="form-check-input" type="radio" id="radioLicencse" name="radioLicencse" value=1 required>
                            <label class="form-check-label" for="radioLicencse">Oui</label>
                        </div>
                        <div class="form-check form-check-inline ml-5">
                            <input class="form-check-input" type="radio" id="radioLicencse" name="radioLicencse" value=0>
                            <label class="form-check-label" for="radioLicencse">Non</label>
                        </div>
                    </div>
                    <!-- /permis de conduire -->

                    <!-- voiture personnelle -->
                    <div class="mb-3">
                        <label class="col-md-3" for="radioPersonalCar">Voiture personnelle</label>
                        <div class="form-check form-check-inline ml-5">
                            <input class="form-check-input" type="radio" id="radioPersonalCar" name="radioPersonalCar" value=1 required>
                            <label class="form-check-label" for="radioPersonalCar">Oui</label>
                        </div>
                        <div class="form-check form-check-inline ml-5">
                            <input class="form-check-input" type="radio" id="radioPersonalCar" name="radioPersonalCar" value=0>
                            <label class="form-check-label" for="radioPersonalCar">Non</label>
                        </div>
                    </div>
                    <!-- /voiture personnelle -->

                    <!-- personne a prevenir en cas d urgence -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="emergency">Personne à prevenir en cas d'urgence</label>
                            <input type="text" class="form-control" id="emergency" name ="emergency" placeholder="" value="" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="emergencyPhone">Numéro de téléphone</label>
                            <input type="text" class="form-control" id="emergencyPhone"  name ="emergencyPhone" placeholder="" value="" required>
                        </div>
                    </div>
                    <!-- /personne a prevenir en cas d urgence -->

                    <!-- diplome obtenu -->
                     <?php 
                        //-------------------------------------------------------------------
                        // appelle de la fonction pour remplir la liste deroulante
                        //-------------------------------------------------------------------
                        $degreeList = dropDownListReader('diplome');
                        //var_dump($degreeList); die;     
                    ?>
                    <div class="mb-3">
                        <label for="degreeObtained">Diplôme obtenu</label>
                        <select class="custom-select d-block w-100" id="degreeObtained" name="degreeObtained" required>
                            <option value="" disabled selected>Sélectionnez...</option>
                            <!---------------------------------//-------------------------------------------
                                                    boucle pour remplir la liste deroulante-->
                            <?php
                                foreach ($degreeList as $key => $column) {
                            ?>
                            <option value=<?=$column['diplome_ID'] ?> ><?=$column['diplome_libelle'] ?></option>
                            <?php
                                }
                            ?>
                            <!--                 boucle pour remplir la liste deroulante
                            ---------------------------------//------------------------------------------->
                        </select>
                    </div>
                    <!-- /diplome obtenu -->

                    <!-- derniere classe -->
                    <div class="mb-3">
                        <label for="lastClass">Dernière classe fréquentée</label>
                        <input type="text" class="form-control" id="lastClass" name="lastClass" placeholder="" value="" required>
                    </div>
                    <!-- /derniere classe -->

                    <!-- niveau d etude -->
                    <?php 
                        //-------------------------------------------------------------------
                        // appelle de la fonction pour remplir la liste deroulante
                        //-------------------------------------------------------------------
                        $gradeList = dropDownListReader('niveau_etude');
                        //var_dump($gradeList); die;     
                    ?>
                    <div class="mb-3">
                        <label for="gradeLevel">Niveau d'étude</label>
                        <select class="custom-select d-block w-100" id="gradeLevel" name="gradeLevel" required>
                            <option value="" disabled selected>Sélectionnez...</option>
                            <!---------------------------------//-------------------------------------------
                                                    boucle pour remplir la liste deroulante-->
                            <?php
                                foreach ($gradeList as $key => $column) {
                            ?>
                            <option value=<?=$column['niveau_etude_ID'] ?> ><?=$column['niveau_etude_Libele'] ?></option>
                            <?php
                                }
                            ?>
                            <!--                 boucle pour remplir la liste deroulante
                            ---------------------------------//------------------------------------------->
                        </select>
                    </div>
                    <!-- /niveau d etude -->
                </div>
                <!----------------------------------------------------------------------------------------------------
                                                                            etat civil
                -------------------------------------------------//---------------------------------------------------->

                <!-----------------------------------------------//---------------------------------------------------
                                                                        coordonnees
                ----------------------------------------------------------------------------------------------------->
                <!--------------------------------------------------------------------------------------------------
                ///////////////////////////////////  TODO - dynamic localization    /////////////////////////////////////
                ---------------------------------------------------------------------------------------------------->                                        
                <div class="col-md-12 px-0">
                    <h4 class="p-3 my-5 bg-info text-white text-uppercase">Vos coordonnées</h4>
                    <!-- adresse -->
                    <div class="mb-3">
                        <label for="address">Adresse</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="1234 Place de la république" value="" required>
                    </div>

                    <div class="mb-3">
                        <label for="address2">Adresse suite <span class="text-muted">(Optionnel)</span></label>
                        <input type="text" class="form-control" id="address2" name="address2"placeholder="Appartement, étage...">
                    </div>
                    <!-- /adresse -->

                    <!-- code postal & ville -->
                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <label for="zip">Code postal</label>
                            <input type="text" class="form-control" id="zip" name="zip" placeholder="" required>
                        </div>

                        <div class="col-md-7 mb-3">
                            <label for="state">Ville</label>
                            <input type="text" class="form-control" id="ville" name="ville" placeholder="" required>
                        </div>
                    </div>
                    <!-- code postal & ville -->

                    <!-- telephone fixe & portable -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="landlinePhone">Téléphone fixe</label>
                            <input type="text" class="form-control" id="landlinePhone" name ="landlinePhone" placeholder="" value="">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="cellPhone">Téléphone portable</label>
                            <input type="text" class="form-control" id="cellPhone" name ="cellPhone" placeholder="" value="">
                        </div>
                    </div>
                    <!-- /telephone fixe & portable -->

                    <!-- email -->
                    <div class="mb-3">
                        <label for="email">E-mail</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">@</span>
                            </div>
                            <input type="email" class="form-control" id="email" name="email" placeholder="you@example.com" required>
                        </div>
                    </div>
                    <!-- /email -->
                </div>
                <!-----------------------------------------------//---------------------------------------------------
                                                                        coordonnees
                ----------------------------------------------------------------------------------------------------->
                
                 <!-----------------------------------------------//---------------------------------------------------
                                                                            situation
                ----------------------------------------------------------------------------------------------------->
                <div class="col-md-12 px-0">
                    <h4 class="p-3 my-5 bg-info text-white text-uppercase">Votre situation</h4>
                    <!-- situation familiale a nombre d enfant -->
                    <?php 
                        //-------------------------------------------------------------------
                        // appelle de la fonction pour remplir la liste deroulante
                        //-------------------------------------------------------------------
                        $maritalStatusList = dropDownListReader('situation_famille');
                        //var_dump($maritalStatusList); die;     
                    ?>
                     <div class="row">
                        <div class="col-md-7 mb-3">
                            <label for="maritalStatus">Situation familiale</label>
                            <select class="custom-select d-block w-100" id="maritalStatus" name="maritalStatus" required>
                                <option value="" disabled selected>Sélectionnez...</option>
                                <!---------------------------------//-------------------------------------------
                                                    boucle pour remplir la liste deroulante-->
                                <?php
                                    foreach ($maritalStatusList as $key => $column) {
                                ?>
                                <option value=<?=$column['situation_famille_ID'] ?> ><?=$column['situation_famille_libele'] ?></option>
                                <?php
                                    }
                                ?>
                                <!--                 boucle pour remplir la liste deroulante
                                ---------------------------------//------------------------------------------->
                            </select>
                        </div>
                        
                        <div class="col-md-5 mb-3">
                            <label for="numDependentChild">Nombre d'enfant(s) à charge</label>
                            <input type="text" class="form-control" id="numDependentChild" name="numDependentChild" value = 0 placeholder="">
                        </div>
                    </div>
                    <!-- /situation familiale a nombre d enfant -->

                    <hr class="mb-4">                        

                    <!-- demandeur d emploi -->
                    <div class="bg-light p-2">                        
                        <h5 class="mb-4"><em>Demandeur d'emploi</em></h5>
                        <!-- inscription & numero identifiant -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="dateRegistration">Date d'inscription au Pôle Emploi</label>
                                <input type="date" class="form-control" id="dateRegistration"  name ="dateRegistration" placeholder="" value="" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="IDnumber">N° identifiant</label>
                                <input type="text" class="form-control" id="IDnumber" name ="IDnumber" placeholder="" value="" required>
                            </div>
                        </div>
                        <!-- /inscription & numero identifiant -->

                        <!-- agence & conseiller -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="agencyOf">Agence de</label>
                                <input type="text" class="form-control" id="agencyOf" name ="agencyOf" placeholder="" value="" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="consultant">Nom de la conseillère/du conseiller</label>
                                <input type="text" class="form-control" id="consultant" name ="consultant" placeholder="" value="" required>
                            </div>
                        </div>
                        <!-- /nom & prenom -->

                        <!-- indemnisation pole emploi -->
                        <div class="mb-3">
                            <label class="col-md-3" for="radioCompensation">Indemnisation Pôle Emploi</label>
                            <div class="form-check form-check-inline ml-5">
                                <input class="form-check-input" type="radio" id="radioCompensation" name="radioCompensation" value=1 required>
                                <label class="form-check-label" for="radioCompensation">Oui</label>
                            </div>
                            <div class="form-check form-check-inline ml-5">
                                <input class="form-check-input" type="radio" id="radioCompensation" name="radioCompensation" value=0>
                                <label class="form-check-label" for="radioCompensation">Non</label>
                            </div>
                        </div>
                        <!-- /indemnisation pole emploi -->

                        <!-- type indemnisation pole emploi -->
                        <div class="mb-3">
                            <label class="col-md-3" for="radioTypeCompensation">Si oui laquelle ?</label>
                            <div class="form-check form-check-inline ml-5">
                                <input class="form-check-input" type="radio" id="radioTypeASS" name="radioTypeCompensation" value=1>
                                <label class="form-check-label" for="radioTypeCompensation">ASS</label>
                            </div>
                            <div class="form-check form-check-inline ml-5">
                                <input class="form-check-input" type="radio" id="radioTypeARE" name="radioTypeCompensation" value=2>
                                <label class="form-check-label" for="radioTypeCompensation">ARE</label>
                            </div>
                            <div class="form-check form-check-inline ml-5">
                                <input class="form-check-input" type="radio" id="radioTypeOther" name="radioTypeCompensation" value=3>
                                <label class="form-check-label" for="radioTypeCompensation">Autre</label>
                            </div>
                        </div>
                        <!-- /type indemnisation pole emploi -->

                        <!-- beneficiaire RSA -->
                        <div class="mb-3">
                            <label class="col-md-3" for="radioBeneficiaryRSA">Etes-vous bénéficiaire du RSA</label>
                            <div class="form-check form-check-inline ml-5">
                                <input class="form-check-input" type="radio" id="radioBeneficiaryRSA" name="radioBeneficiaryRSA" value=1 required>
                                <label class="form-check-label" for="radioBeneficiaryRSA">Oui</label>
                            </div>
                            <div class="form-check form-check-inline ml-5">
                                <input class="form-check-input" type="radio" id="radioBeneficiaryRSA" name="radioBeneficiaryRSA" value=0>
                                <label class="form-check-label" for="radioBeneficiaryRSA">Non</label>
                            </div>
                        </div>
                        <!-- /beneficiaire RSA -->

                        <!-- ayant droit -->
                        <div class="mb-3">
                            <label class="col-md-3" for="radioRightfulClaimant">Ou ayant droit</label>
                            <div class="form-check form-check-inline ml-5">
                                <input class="form-check-input" type="radio" id="radioRightfulClaimant" name="radioRightfulClaimant" value=1 required>
                                <label class="form-check-label" for="radioRightfulClaimant">Oui</label>
                            </div>
                            <div class="form-check form-check-inline ml-5">
                                <input class="form-check-input" type="radio" id="radioRightfulClaimant" name="radioRightfulClaimant" value=0>
                                <label class="form-check-label" for="radioRightfulClaimant">Non</label>
                            </div>
                        </div>
                        <!-- /ayant droit -->                    
                    </div>
                    <!-- demandeur d emploi -->
                </div>
                <!-----------------------------------------------//---------------------------------------------------
                                                                            situation
                ----------------------------------------------------------------------------------------------------->
                <hr class="mb-4">
                <!-- bouton validation du dossier de candidature -->
                <button class="btn btn-primary btn-lg btn-block" type="submit" name="submit">Choisir votre formation</button>
                <!-- /bouton validation du dossier de candidature -->
            </form>
            <!---------------------- /formulaire pour le dossier du candidat ---------------------------->        
            <!--------------------------------------//-------------------------------------------------------------
                            /container global pour afficher le formulaire pour le dossier du candidat
            -------------------------------------------------//---------------------------------------------------->   
        </div>

        <!-- import du header -->
        <?php include 'includes/footer.php'; ?>
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
