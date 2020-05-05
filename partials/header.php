<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top py-0">
    <!-- navbar brand & logo -->
    <a class="navbar-brand text-uppercase" href="/index.php">
        <img class="d-inline-block align-center" src="/images/header/octopus-logo.png" width="50" height="50" alt="Octopus Logo">
        octopus
    </a>
    <!-- /navbar brand & logo -->
    <!-- collapse button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <!-- /collapse button -->
    <!-- collapsible content -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <div class="navbar-nav ml-auto">
            <a class="nav-link" href="<?= ($_SESSION['current']['login']) ? '/logout.php' : '/index.php' ?>"><i class="fa <?= ($_SESSION['current']['login']) ? 'fa-sign-out' : 'fa-sign-in' ?>" aria-hidden="true"></i> <?= ($_SESSION['current']['login']) ? 'Logout' : 'Login' ?></a>
        </div>
    </div>
    <!-- collapsible content -->
</nav>