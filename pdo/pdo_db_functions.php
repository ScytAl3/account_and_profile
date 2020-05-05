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
function userExist($where, $valueToTest) {
    // on instancie une connexion
    $pdo = my_pdo_connexxion();
    // preparation de la  requete preparee pour verifier si la condition testee renvoie un resultat
    $query = "SELECT * FROM users WHERE $where = :bp_where";
    // preparation de l execution de la requete
    try {
        $statement = $pdo -> prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        // passage de la valeur a tester en  parametre
        $statement->bindParam(':bp_where', $valueToTest, PDO::PARAM_STR);
        // execution de la requete
        $statement -> execute(); 
        $count = $statement->rowCount();       
        // --------------------------------------------------------------
        //var_dump($count = $statement->fetch()); die; 
        // --------------------------------------------------------------
        // si on trouve un resultat
        if ($count == 1) {
            // on recupere les donnees qui sont associees a l utilisateur 
            $userExist= $statement->fetch(); 
        } else {
            $userExist = false;
        }         
        $statement -> closeCursor();
    } catch(PDOException $ex) {         
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
function validPassword($loginPwd, $user) {
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
function createUser($userData) {
    // on instancie une connexion
    $pdo = my_pdo_connexxion();
    // preparation de la requete pour creer un utilisateur
    $sqlInsert = "INSERT INTO 
                                users (`userLastName`, `userFirstName`, `userEmail`, `userPassword`, `userSalt`, `accountCreated_at`, `userRole`) 
                            VALUES 
                                (?, ?, ?, ?, ?, now(), DEFAULT)";
    // preparation de la requete pour execution
    try {
        $statement = $pdo -> prepare($sqlInsert, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        // execution de la requete
        $statement -> execute($userData);
        $statement -> closeCursor();
    } catch(PDOException $ex) {         
        $statement = null;
        $pdo = null;
        $msg = 'ERREUR PDO create user...' . $ex->getMessage();
        die($msg); 
    }
    // on retourne le dernier Id cree
    return $pdo -> lastInsertId(); 
}
