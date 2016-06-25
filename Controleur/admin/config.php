<?php

if(!isset($_SESSION['admin'])){
    header('Location:index.php');
}

//Load config
$config = Config::getInstance();
$token = Security::generateToken();

$alerte = array();

if(isset($_POST['submit'])){
    if(!isset($_POST['csrf']) || !Security::isTokenValid($_POST['csrf']))
        $alerte[] = array('error', 'Attaque CSRF détectée');
    
    if(empty($alerte)){
        //Formulaire validé -> une seule chose à vérifier
        $publication = (bool)$_POST['publish_commentaires'];
        //On sauvegarde
        $alerte[] = ($config->setConfig('publish_commentaires', $publication)) ? array('info', 'La configuration a été modifiée avec succès') : array('error', 'La configuration n\'a pas pu être modifiée.  Les droits d\'écriture sont-ils activés dans le répertoire «Config»?');
    }
}

$_SESSION['alertes'] = serialize(array($reponse));

$templateName = 'admin/config.php';

//Affichage du template
require_once('Vue/main.php');
?>
