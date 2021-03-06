<?php
// -- import du script de connexion a la db
require 'pdo_db_connect.php';
// -- import du script des fonctions speciales
require 'pdo_special_functions.php';

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                                      Les Fonctions utilisateurs                                          //
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

// ---------------------------------------------//-----------------------------------------
//      fonction pour verifier l existence d un champ dans la table users
// ---------------------------------------------//-----------------------------------------
/**
 * renvoie les informations d'un utlisateur en fonction d une condition
 * 
 * @param String    nom du champ sur lequel porte la condition
 * @param String    input saisi par l utilisateur
 * 
 * @return Mixed    retourne un tableau si un resultat a ete trouve - FALSE sinon
 */
function userExist($where, $valueToTest)
{
    // on instancie une connexion
    $pdo = my_pdo_connexxion();
    // preparation de la  requete preparee pour verifier si la condition testee renvoie un resultat
    $query = "SELECT * FROM users WHERE $where = :bp_where";
    // preparation de l execution de la requete
    try {
        $statement = $pdo->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        // passage de la valeur a tester en  parametre
        $statement->bindParam(':bp_where', $valueToTest, PDO::PARAM_STR);
        // execution de la requete
        $statement->execute();
        $count = $statement->rowCount();
        // --------------------------------------------------------------
        //var_dump($count = $statement->fetch()); die; 
        // --------------------------------------------------------------
        // si on trouve un resultat
        if ($count == 1) {
            // on recupere les donnees qui sont associees a l utilisateur 
            $userExist = $statement->fetch();
        } else {
            $userExist = false;
        }
        $statement->closeCursor();
    } catch (PDOException $ex) {
        $statement = null;
        $pdo = null;
        $msg = 'ERREUR PDO Check User Exist...' . $ex->getMessage();
        die($msg);
    }
    $statement = null;
    $pdo = null;
    // on retourne le resultat
    return $userExist;
}

// ------------------------------------------------------------
//           fonction pour verifier le mot de passe
// ------------------------------------------------------------
/**
 * verifie la correspondance entre le mot de passe saisi et celui dans la base de donnees
 * 
 * @param String    mot de passe saisi par l utilisateur
 * @param Array     tableau des informations trouver dans la base apres validation de l adresse email
 * 
 * @return Boolean  renvoie TRUE si le mot de passe saisi est le meme - sinon FALSE
 */
function validPassword($loginPwd, $user)
{
    // on on appelle la fonction speciale qui verifie le mot de passe saissi grace au Salt et mot de passe chiffre associes a l utilisateur
    $checkPwd = VerifyEncryptedPassword($user['salt'], $user['password'], $loginPwd);
    // ------------------------------------
    //var_dump($checkPwd); die;
    // ------------------------------------
    // si identique
    if ($checkPwd) {
        $user_valid = true;
    } else {
        $user_valid = false;
    }
    // on retourne le resultat
    return $user_valid;
}

// -----------------------------------------------------------
//              fonction pour creer un utilisateur
// -----------------------------------------------------------
/**
 * creer un utilisateur dans la base de donnees
 * 
 * @param Array tableau contenant les informations saisies dans le formulaire d inscription
 * 
 * @return Int  retourne le numero d identification qui vient d etre cree
 */
function createUser($userData)
{
    // on instancie une connexion
    $pdo = my_pdo_connexxion();
    // preparation de la requete pour creer un utilisateur
    $sqlInsert = "INSERT INTO 
                                users (`lastName`, `firstName`, `dateOfBirth`, `placeOfBirth`, `astrological_sign`, `email`, `password`, `salt`, `presentation`, `role`, `created_at`) 
                            VALUES 
                                (?, ?, ?, ?, ?, ?, ?, ?, ?, DEFAULT, now())";
    // preparation de la requete pour execution
    try {
        $statement = $pdo->prepare($sqlInsert, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        // execution de la requete
        $statement->execute($userData);
        $statement->closeCursor();
    } catch (PDOException $ex) {
        $statement = null;
        $pdo = null;
        $msg = 'ERREUR PDO create user...' . $ex->getMessage();
        die($msg);
    }
    // on retourne le dernier Id cree
    return $pdo->lastInsertId();
}

// ---------------------------------------------------------------------------
//              fonction pour remplir les listes deroulantes
// ---------------------------------------------------------------------------
/**
 * retourne le numero identifiant et le libele des tables servant a remplir les listes deroulantes
 * 
 * @param String    nom de la table sur lequel porte le select
 * 
 * @return Array    retourne un tableau avec la liste des informations demandees
 */
function dropDownListReader($table)
{
    // on instancie une connexion
    $pdo = my_pdo_connexxion();
    // PDO pour creer une exception en cas d'erreur afin de faciliter le traitement des erreurs
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    try {
        // preparation de la requete preparee 
        $queryList = "SELECT `sign_name` FROM $table";
        // preparation de la requete pour execution
        $statement = $pdo->prepare($queryList, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        // execution de la requete
        $statement->execute();
        // on verifie s il y a des resultats
        // --------------------------------------------------------
        //var_dump($statement->fetchColumn()); die; 
        // --------------------------------------------------------
        if ($statement->rowCount() > 0) {
            $myReader = $statement->fetchAll();
        } else {
            $myReader = false;
        }
        $statement->closeCursor();
    } catch (PDOException $ex) {
        $statement = null;
        $pdo = null;
        $msg = "ERREUR PDO Liste déroulate $table.." . $ex->getMessage();
        die($msg);
    }
    // on retourne le resultat
    return $myReader;
}

// -----------------------------------------------------------------------------------------------------------
//    fonction pour mettre a jour le profil d un utilisateur - sans changement de mot de passe
// -----------------------------------------------------------------------------------------------------------
/**
 * mise a jour des informations du profil - meme mot de passe
 * @param Array nouvelles informations saisies & numero identifiant de l utilisateur
 * 
 * @return String   renvoie un message de bon deroulement ou d erreur
 */
function updateSimpleProfil($arrayProfile)
{
    //
    // var_dump($arrayProfile);die;
    //
    // on instancie une connexion
    $pdo = my_pdo_connexxion();
    // preparation de la  requete preparee pour mettre a jour les informations
    $sql = "UPDATE `users` SET `lastName` = :bp_lastName,
                                `firstName` = :bp_firstName,
                                `dateOfBirth` = :bp_dateOfBirth,
                                `placeOfBirth` = :bp_placeOfBirth,
                                `astrological_sign` = :bp_astrological_sign,
                                `email` = :bp_email,
                                `presentation` = :bp_presentation
                                ";
    $where = " WHERE id = :bp_id";
    // construction de la requete
    $query = $sql . $where;
    // preparation de l execution de la requete
    try {
        $statement = $pdo->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        // passage des valeurs en  parametres
        $statement->bindParam(':bp_lastName', $arrayProfile['lastName'], PDO::PARAM_STR);
        $statement->bindParam(':bp_firstName', $arrayProfile['firstName'], PDO::PARAM_STR);
        $statement->bindParam(':bp_dateOfBirth', $arrayProfile['dateOfBirth'], PDO::PARAM_STR);
        $statement->bindParam(':bp_placeOfBirth', $arrayProfile['placeOfBirth'], PDO::PARAM_STR);
        $statement->bindParam(':bp_astrological_sign', $arrayProfile['astrological_sign'], PDO::PARAM_STR);
        $statement->bindParam(':bp_email', $arrayProfile['email'], PDO::PARAM_STR);
        $statement->bindParam(':bp_presentation', $arrayProfile['presentation'], PDO::PARAM_STR);
        $statement->bindParam(':bp_id', $arrayProfile['userId'], PDO::PARAM_INT);
        // execution de la requete
        $statement->execute();
        $statement->closeCursor();
        $msg =  "Données du profil modifiées !";
    } catch (PDOException $ex) {
        $statement = null;
        $pdo = null;
        $msg = 'ERREUR PDO update profil simple...' . $ex->getMessage();
        die($msg);
    }
    $statement = null;
    $pdo = null;
    // on retourne le resultat
    return $msg;
}

// -----------------------------------------------------------------------------------------------------------
//    fonction pour mettre a jour le profil d un utilisateur - sans changement de mot de passe
// -----------------------------------------------------------------------------------------------------------
/**
 * mise a jour des informations du profil - nouveau mot de passe
 * @param Array nouvelles informations saisies & numero identifiant de l utilisateur
 * 
 * @return String   renvoie un message de bon deroulement ou d erreur
 */
function updateFullProfil($arrayProfile)
{
    //
    // var_dump($arrayProfile);die;
    //
    // on instancie une connexion
    $pdo = my_pdo_connexxion();
    // preparation de la  requete preparee pour mettre a jour les informations
    $sql = "UPDATE `users` SET `lastName` = :bp_lastName,
                                `firstName` = :bp_firstName,
                                `dateOfBirth` = :bp_dateOfBirth,
                                `placeOfBirth` = :bp_placeOfBirth,
                                `astrological_sign` = :bp_astrological_sign,
                                `email` = :bp_email,
                                `password` = :bp_password,
                                `salt` = :bp_salt,
                                `presentation` = :bp_presentation
                                ";
    $where = " WHERE id = :bp_id";
    // construction de la requete
    $query = $sql . $where;
    // preparation de l execution de la requete
    try {
        $statement = $pdo->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        // passage des valeurs en  parametres
        $statement->bindParam(':bp_lastName', $arrayProfile['lastName'], PDO::PARAM_STR);
        $statement->bindParam(':bp_firstName', $arrayProfile['firstName'], PDO::PARAM_STR);
        $statement->bindParam(':bp_dateOfBirth', $arrayProfile['dateOfBirth'], PDO::PARAM_STR);
        $statement->bindParam(':bp_placeOfBirth', $arrayProfile['birthPlace'], PDO::PARAM_STR);
        $statement->bindParam(':bp_astrological_sign', $arrayProfile['astrological_sign'], PDO::PARAM_STR);
        $statement->bindParam(':bp_email', $arrayProfile['email'], PDO::PARAM_STR);
        $statement->bindParam(':bp_password', $arrayProfile['password'], PDO::PARAM_STR);
        $statement->bindParam(':bp_salt', $arrayProfile['salt'], PDO::PARAM_STR);
        $statement->bindParam(':bp_presentation', $arrayProfile['presentation'], PDO::PARAM_STR);
        $statement->bindParam(':bp_id', $arrayProfile['userId'], PDO::PARAM_INT);
        // execution de la requete
        $statement->execute();
        $statement->closeCursor();
        $msg =  "Données du profil modifiées !";
    } catch (PDOException $ex) {
        $statement = null;
        $pdo = null;
        $msg = 'ERREUR PDO update profil complet...' . $ex->getMessage();
        die($msg);
    }
    $statement = null;
    $pdo = null;
    // on retourne le resultat
    return $msg;
}
