<?php

if(!isset($_SESSION['admin'])){
    header('Location:index.php');
}

$articleManager = new ArticleModele();
$listeArticles = $articleManager->getArticlesList();

$code = Security::generateToken();

$templateName = 'admin/viewArticles.php';

//Affichage du template
require_once('Vue/main.php');
