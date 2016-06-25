<?php

//Contrôleur frontal pour l'admin

//Connexion très très simple -> juste $_SESSION
if(!isset($_SESSION['admin']) && !isset($_POST['submit'])){
    header('Location:index.php');
}

//Vérification du login
if(isset($_POST['submit'])){
    if(!empty($_POST['pseudo'])){
        $sql = Sql::getInstance()->getPDO();
        $query = $sql->prepare('SELECT passwd FROM utilisateurs WHERE pseudo=:pseudo');
        $query->bindParam('pseudo', $_POST['pseudo'], PDO::PARAM_STR);
        $query->execute();
        $resultat = $query->fetch();
        if($resultat === FALSE){
            $_SESSION['login_msg'] = '<p class="error">Pseudo invalide</p>';
            header('Location: index.php');
        }
        else{
            if(password_verify($_POST['passwd'], $resultat['passwd'])){
                $_SESSION['admin'] = true;
                $_SESSION['pseudo'] = $_POST['pseudo'];
            }
            else{
                $_SESSION['login_msg'] = '<p class="error">Mot de passe invalide</p>';
                header('Location:index.php');
            }
        }
    }
    else
        header('Location:index.php');
}

$templateName = 'admin/index.php';

//Affichage du template
require_once('Vue/main.php');
