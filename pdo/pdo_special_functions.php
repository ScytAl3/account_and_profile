<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                      Les Fonctions chiffrement                                           //
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

// --------------------------------------------------------------
// FONCTION : Generer Salt
// --------------------------------------------------------------
/**
 * genere uns Salt qui sera associe a un compte pour chiffrer le mot de passe
 * 
 * @return String   chaine aleatoire de 10 caracteres
 */
function generateSalt($lenght = 10)
{
    $allowedChar = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $maxLenght = strlen($allowedChar);
    $randomString = '';
    for ($i = 0; $i < $lenght; $i++) {
        $randomString .= $allowedChar[rand(0, $maxLenght - 1)];
    }
    $encryptedSalt = md5($randomString);
    return $encryptedSalt;
}

// --------------------------------------------------------------
// FONCTION : Hashage du mot de passe
// --------------------------------------------------------------
/**
 * retourne une chaine chiffree
 * 
 * @param String    le Salt associe a un utilisateur
 * @param String    la chaine de caractere saisie par l utilisateur lors de la creation de son compte
 * 
 * @return String   chaine chiffree
 */
function CreateEncryptedPassword($salt, $password)
{
    $md5Pwd = md5($password);
    $encryptedPwd = md5($salt . $md5Pwd);
    return $encryptedPwd;                   // génère 60 caractères
};

// --------------------------------------------------------------
// FONCTION : Verification du mot de passe
// --------------------------------------------------------------
/**
 * verifie le mot de passe saisi avec celui enregistre dans la base de donnees
 * 
 * @param String    le salt associe a l utilisateur stocke dans la base de donnees
 * @param String    le mot de passe associe a l utilisateur stocke dans la base de donnees
 * @param String    le mot de passe saisi lors de l authentification
 * 
 * @return Boolean  renvoie TRUE si le mot de passe saisi correspond - sinon FALSE
 */
function VerifyEncryptedPassword($userSalt, $userPwd, $loginPwd)
{
    $encryptLoginPwd = CreateEncryptedPassword($userSalt, $loginPwd);
    return ($userPwd == $encryptLoginPwd) ? true : false;
};

/* 
// pour construire le jeu de donnees users
$pwdIn = "c4tchM3";
// genere le salt
$mySalt = generateSalt(10);
echo 'le salt = '.$mySalt."\n";
// genere le mdp
$myPwd = CreateEncryptedPassword($mySalt, $pwdIn);
echo 'le pwd chiffré : '.$myPwd."\n";
// verifie le mdp et le 
$check = VerifyEncryptedPassword($mySalt, $myPwd, $pwdIn);
var_dump($check);
*/


//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                      Les Fonctions diverses                                              //
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

// -----------------------------------------------------------------------------------
// FONCTION : Controle de la saisie a l'aide des expressions régulières
// -----------------------------------------------------------------------------------
function stringFormat($inputString)
{
    $pattern = "/^[A-ZÉÈÀÙÂÊÎÔÛÄËÏÖÜÇ]{1}[-a-z ]*$/";
    return (!preg_match($pattern, $inputString)) ? false : true;
}

function mailFormat($inputMail)
{
    $pattern = "/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix";
    return (!preg_match($pattern, $inputMail)) ? false : true;
}

function pwdFormat($pwdInput)
{
    $pattern = "/.*^(?=.{12,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/";
    return (!preg_match($pattern, $pwdInput)) ? false : true;
}

// --------------------------------------------------------------
// FONCTION : Formatage de la date a afficher
// --------------------------------------------------------------
/**
 * formate une date MySQL dans le format choisi
 * 
 * @param Datetime  la date MySQL retournee par une requete SELECT
 * 
 * @return String   la date formatee
 */
function formatedDateTime($mysqlDate)
{
    setlocale(LC_TIME, 'fr', 'fr_FR', 'fr_FR.ISO8859-1');
    // retourne la date au format desire si elle exite
    return ($mysqlDate != '') ? utf8_encode(strftime("%A %d %B %Y.", strtotime($mysqlDate))) : '';
};
