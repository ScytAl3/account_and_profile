<?php
// on démarre la session
session_start();
// import du script pdo des fonctions qui accedent a la base de donnees
require 'pdo/pdo_db_functions.php';
// ----------------------------//---------------------------
//                  variables de session
// ---------------------------------------------------------
//----------------------------//----------------------------
//                      CURRENT SESSION
// nom de la page en cours
$_SESSION['current']['page'] = 'signup';
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
	<title>Compte avec profile | Sign up</title>
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
		<!-----------------------------------//-----------------------------------------
                 					container global
		-------------------------------------------------------------------------------->
		<!--------------------  formulaire de login ----------------------------->
		<div class="col-lg-4 bg-light text-dark rounded mx-auto">
			<h1 class="text-center py-3">Inscription</h1>

			<!-- area pour afficher un message d erreur lors de la validation de l inscription -->
			<div class="alert alert-danger <?= ($_SESSION['error']['message'] != '') ? 'd-block' : 'd-none'; ?> mt-5" role="alert">
				<p class="lead mt-2"><span><?= $_SESSION['error']['message'] ?></span></p>
			</div>
			<!-- /area pour afficher un message d erreur lors de la validation de l inscription -->

			<form class="form-inscription pb-2" action="php_process/<?= ($_SESSION['current']['login'] != true) ? 'signup_process.php' : 'update_profile_process.php'; ?>" method="POST">
				<!-- lastName input -->
				<div class="form-group">
					<label for="lastName">Nom <small>*</small></label>
					<input class="form-control fa fa-user" type="text" name="lastName" id="lastName" placeholder="&#xf007; Votre nom" required>
				</div>

				<!-- firstName input -->
				<div class="form-group">
					<label for="firstName">Prénom <small>*</small></label>
					<input class="form-control fa fa-user" type="text" name="firstName" id="firstName" placeholder="&#xf007; Votre prénom" required>
				</div>

				<!-- date of birth input-->
				<div class="form-group">
					<label for="birthDate">Date de naissance</label>
					<input type="date" class="form-control" id="birthDate" name="birthDate" placeholder="" value="">
				</div>

				<!-- place of birth input-->
				<div class="form-group">
					<label for="birthPlace">Lieu de naissance</label>
					<input class="form-control fa fa-map-marker" type="text" name="birthPlace" id="birthPlace" placeholder="&#xf041; Votre lieu de naissance">
				</div>

				<!-- astrological sign input-->
				<?php
				//-------------------------------------------------------------------
				// appelle de la fonction pour remplir la liste deroulante
				//-------------------------------------------------------------------
				$astrologicalList = dropDownListReader('astrological_sign');
				//
				// var_dump($astrologicalList);die;
				// 
				?>
				<div class="form-group">
					<label for="astrologicalSign">Signe astrologique</label>
					<select class="custom-select d-block" name="astrologicalSign" id="astrologicalSign">
						<option value="" selected>Sélectionnez...</option>
						<!---------------------------------//-------------------------------------------
                                                    boucle pour remplir la liste deroulante-->
						<?php
						foreach ($astrologicalList as $key => $column) {
						?>
							<option value=<?= $column['sign_name'] ?>><?= $column['sign_name'] ?></option>
						<?php
						}
						?>
						<!--                 boucle pour remplir la liste deroulante
                            ---------------------------------//------------------------------------------->
					</select>
				</div>

				<!-- email input-->
				<div class="form-group">
					<label for="email">Email <small>*</small></label>
					<input class="form-control fa fa-envelope" type="text" name="email" id="email" placeholder="&#xf0e0; Votre adresse email" required>
				</div>

				<!-- password input-->
				<div class="form-group">
					<label for="password">Mot de passe <small>*</small></label>
					<input class="form-control fa fa-key" type="password" name="password" id="password" placeholder="&#xf084; Votre mot de passe" required>
				</div>

				<!-- presentation input-->
				<div class="form-group">
					<label for="presentation">Présentation en quelques mots</label>
					<textarea class="form-control fa fa-book" type="text" name="presentation" id="presentation" rows="10" placeholder="&#xf02d; Pas une biographie"></textarea>
				</div>

				<!-- information -->
				<p class="text-center text-muted"><small>*</small> Champs requis</p>

				<!-- buttons area -->
				<!-- submit button -->
				<div class="form-group">
					<button class="btn btn-valid-gradient btn-lg btn-block text-light text-uppercase" type="submit"><?= ($_SESSION['current']['login'] != true) ? 'Inscription' : 'Mettre à jour'; ?></button>
				</div>

				<!-- reset button -->
				<div class="form-group">
					<button class="btn btn-reset-gradient btn-lg btn-block text-light text-uppercase" type="reset">Annuler</button>
				</div>
				<!-- /buttons area -->
			</form>
		</div>
		<!--------------------  /formulaire de login ----------------------------->
		<!------------------------------------------------------------------------------
                 				/container global
		-------------------------------------//----------------------------------------->
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