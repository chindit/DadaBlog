<?php
//BANZAÏ


$page = 1;
$entityManager = new ArticleModele();
/* NOTE AU MENTOR
 * Il ne s'agit pas à proprement parler d'un EntityManager puisque le système est bien plus simpe
 * Néanmoins, pour des raisons de lecture, j'ai choisi ce nom de variable pour m'y repérer facilement.
 * Finalement, les classes *Modele sont des Manager de l'entité «*»… C'est une façon de voir les chose :)
 * J'aurais peut-être dû appeler ces variables «ArticleManager»… Mais ce n'est jamais que le nom d'une variable :D
 */

//Calcul de la page
if(isset($_GET['page']) && is_numeric($_GET['page'])){
    //Si $_GET est bon, on le garde, sinon c'est page 1 par défaut
    $page = 1;
    if($entityManager->isPageInRange((int)$_GET['page'])){
        $page = $_GET['page'];
    }
    else{
        //404!
        header('Location:index.php?controleur=404');
    }
}

//Nombre de pages
$nbPages = $entityManager->getNbPages();

//On récupère les articles
$articles= $entityManager->getPage($page);

//Template pour la page
$templateName = 'index.php';

//Affichage du template
require_once('Vue/main.php');
