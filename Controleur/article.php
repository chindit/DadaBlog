<?php
/**
 *
 * Contrôleur «Article»
 * Gère l'affichage des différents articles
 */
 
 //Vérifie si l'ID est valide
 if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
	//Redirection vers accueil
	header('Location:index.php');
}

$ArticleManager = new ArticleModele();
$commentaireManager = new CommentaireModele();

$alerte = array(); //Variable d'alerte très très simplifiée


try{
    //Récupération de l'article
    $article = $ArticleManager->getArticle($_GET['id']);
}
catch(Exception $e){
    //L'utilisateur a fait l'andouille -> article introuvable
    header('Location:index.php?controleur=404');
}

//Vérifie si un commentaire est posté
//On fait ça APRÈS l'article pour être certain que tout est OK et bénéficier de la vérification automatique de Article
if(isset($_POST['submit'])){
    if(empty($_POST['message']))
        $alerte[] = array('error', 'Votre commentaire ne peut pas être vide!');
    
    //Check email -> ATTENTION!  Email vide autorisé
    if(!empty($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === FALSE)
        $alerte[] = array('error', 'Adresse email invalide!');
    
    if(empty($alerte)){
        //Message + email OK -> on enregistre
        $nvComment = new Commentaire($article);
        $nvComment->setAuteur(filter_var($_POST['pseudo'], FILTER_SANITIZE_STRING));
        if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
            $nvComment->setEmail($_POST['email']); //On ajoute l'email QUE si il est valide (sinon, il reste vide)
        $nvComment->setMessage(filter_var($_POST['message'], FILTER_SANITIZE_STRING));
        $config = Config::getInstance();
        $nvComment->setValide($config->getConfig('publish_commentaires'));
        //Insertion en BDD
        $alerte[] = ($commentaireManager->save($nvComment)) ? array('info', 'Commentaire publié avec succès') : array('error', 'Un problème est survenu lors de l\'enregistrement de votre commentaire.  Veuillez réessayer.');
    }
}

//Récupération des commentaires
$comments = $commentaireManager->getComments($article);

//Messages
$_SESSION['alertes'] = serialize($alerte);

//Article valide -> on affiche
$templateName = 'article.php';

//Affichage du template
require_once('Vue/main.php');
