<?php
// on démarre la session
session_start();
// ----------------------------//---------------------------
//                  variables de session
// ---------------------------------------------------------
//----------------------------//----------------------------
//                              USER
// nom de la page en cours
$_SESSION['current']['page'] = 'signup';
//                              USER
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
	<!-- current page stylesheet -->
	<link href="css/index.css" rel="stylesheet" type="text/css">
	<!-- font import -->
	<link href="https://fonts.googleapis.com/css?family=Oswald&display=swap" rel="stylesheet">
</head>

<body>
	<!-- import du header -->
	<?php include 'partials/header.php'; ?>
	<!-- /import du header -->

	<!-----------------------------------//-----------------------------------------
                 					container global
	-------------------------------------------------------------------------------->
	<!--------------------  formulaire de login ----------------------------->
	<div class="col-lg-4 bg-light text-dark rounded mx-auto">
		<h1 class="text-center py-3">Inscription</h1>

		<!-- area pour afficher un message d erreur lors de la validation du dossier de candidature -->
		<div class="alert alert-danger <?= ($_SESSION['error']['message'] != '') ? 'd-block' : 'd-none'; ?> mt-5" role="alert">
			<p class="lead mt-2"><span><?= $_SESSION['error']['message'] ?></span></p>
		</div>
		<!-- /area pour afficher un message d erreur lors de la validation du dossier de candidature -->

		<form class="form-inscription" action="form_processing/signup_process.php" method="POST">
			<!-- nom -->
			<div class="mb-4">
				<label for="lastName">Nom</label>
				<input class="form-control" name="lastName" id="lastName" type="text" required pattern="^[A-Za-z -]{1,75}$">
			</div>

			<!-- prenom -->
			<div class="mb-4">
				<label for="firstName">Prénom</label>
				<input class="form-control" name="firstName" id="firstName" type="text" required pattern="^[A-Za-z -]{1,75}$">
			</div>

			<!-- email -->
			<div class="mb-4">
				<label for="email">Courriel</label>
				<input class="form-control" type="email" name="email" id="email" placeholder="utilisateur@domaine.fr" required pattern="^[\w!#$%&'*+/=?`{|}~^-]+(?:\.[\w!#$%&'*+/=?`{|}~^-]+)*@(?:[a-zA-Z0-9-]+\.)+[a-zA-Z]{2,6}$">
			</div>

			<!-- Mot de passe -->
			<div class="mb-4">
				<label for="pwd1">Mot de passe</label>
				<input class="form-control" name="password" id="password" type="password" required>
			</div>
			<!-- Mot de passe confirmation -->
			<div class="mb-4">
				<label for="pwd2">Mot de passe <span class="text-muted">(confirmation)</span>
				</label>
				<input class="form-control" name="confirm_password" id="confirm_password" type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
			</div>

			<hr class="my-4">

			<!-- buttons area -->
			<div class="container mb-3">
				<div class="row justify-content-center">
					<!-- submit button -->
					<div class="col-md-4 mb-3">
						<button class="btn btn-primary btn-lg btn-block" type="submit">Submit</button>
					</div>
					<!-- reset button -->
					<div class="col-md-4 mb-3">
						<button class="btn btn-primary btn-lg btn-block" type="reset">Reset</button>
					</div>
				</div>
			</div>
			<!-- /buttons area -->
		</form>
	</div>
	<!--------------------  /formulaire de login ----------------------------->
	<!------------------------------------------------------------------------------
                 				/container global
	-------------------------------------//----------------------------------------->

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