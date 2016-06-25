<?php

if(!isset($_SESSION['admin'])){
    header('Location:index.php');
}

$commentaireManager = new CommentaireModele();
$alerte = array();

//Vérification des soumissions
$actions = array('delete', 'valide');
if(isset($_GET['id']) && isset($_GET['action']) && in_array($_GET['action'], $actions)){
    if(!isset($_GET['token']) || !Security::isTokenValid($_GET['token'])){
        $alerte[] = array('error', 'Attaque CSRF détectée');
    }
    else{
        //Action OK
        $commentaire = $commentaireManager->getComment($_GET['id']);
        if($_GET['action'] == 'delete'){
            $commentaireManager->delete($commentaire);
            $alerte[] = array('info', 'Commentaire correctement supprimé');
        }
        else if($_GET['action'] == 'valide'){
            $commentaire->setValide(true);
            $commentaireManager->save($commentaire);
            $alerte[] = array('info', 'Commentaire correctement publié');
        }
        else{
            //CHAMPAGNE!
            //Il est IMPOSSIBLE d'arriver ici!  Même en dansant sur sa tête ou en codant avec ses pieds!
            throw new Exception('BANG!  Impossible!');
        }
    }
}

$listeCommentaires = $commentaireManager->getUnpublishedComments();

//CSRF
$code = Security::generateToken();
$_SESSION['alertes'] = serialize($alerte);
$templateName = 'admin/valide.php';

//Affichage du template
require_once('Vue/main.php');

