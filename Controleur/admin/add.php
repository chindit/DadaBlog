<?php

if(!isset($_SESSION['admin'])){
    header('Location:index.php');
}

$alerte = array();
$articleManager = new ArticleModele();

//Soumission de l'article
if(isset($_POST['submit'])){
    if(!isset($_POST['csrf']))
        $alerte[] = array('error', 'Un problème est survenu lors de la validation.  Veuillez réessayer');
    if(!Security::isTokenValid($_POST['csrf']))
        $alerte[] = array('error', 'Une attaque CSRF a été détectée');

    //Arf… CSRF OK
    if(empty($_POST['titre']) || strlen($_POST['titre']) > 150)
        $alerte[] = array('error', 'Le titre est invalide</p>');
    if(empty($_POST['contenu']) || strlen($_POST['contenu']) < 50)
        $alerte[] = array('error', 'Le contenu est invalide');
    
    if(empty($alerte)){
        //Formulaire OK
        $article = (isset($_GET['id'])) ? $articleManager->getArticle($_GET['id']) : new Article();
        $article->setTitre($_POST['titre']);
        $article->setContenu(htmlspecialchars($_POST['contenu']));
        $article->setAuteur(htmlspecialchars($_SESSION['pseudo']));
        $articleManager->save($article);
        $alerte[] = array('info', 'Article correctement ajouté');
    }
}

//Édition/suppression de l'article
$article = false;
$iee = false; //Variable pour l'édition.  «iee» = «Is Edit Enabled».  Pour vérifier facilement si on est en mode édition ou non
if(isset($_GET['id']) && !isset($_POST['submit'])){
    //Désactivation en cas de soumission
    $article = $articleManager->getArticle($_GET['id']);
    if(!isset($_GET['token']) || !Security::isTokenValid($_GET['token']))
        $alerte .= array('error', 'Faille CSRF détectée!');
    else{
        if(isset($_GET['action']) && $_GET['action'] == 'delete'){
            $articleManager->delete($article);
            $alerte[] = array('info', 'L\'article a été correctement supprimé');
            $_SESSION['alertes'] = serialize($alerte);
            header('Location: index.php?controleur=admin/index');
        }
    }
    $iee = true;
}

//Messages
$_SESSION['alertes'] = serialize($alerte);

//CSRF
$code = Security::generateToken();

$templateName = 'admin/add.php';

//Affichage du template
require_once('Vue/main.php');
