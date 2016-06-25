<?php
/**
 * Bienvenue à bord de Dada Airlines. 
 * Nous espérons que votre voyage en notre compagnie sera fructueux. 
 * Pour rappel en tant que Mentor Premium, vous pouvez bénéficier de notre programme «Code & More». 
 * Pour 1000 lignes de code consommées chez nous, une ligne de code vous est offerte. :P 
 * Des rafraîchissements sous forme de HTML sont également disponibles au bar «Vue/*»
 * -Votre Commandant de Code-
 * 
 * Contrôleur frontal
 */

    //Chargement automatique des classes:
    spl_autoload_register(function ($clase) {
       include 'Modele/' . $clase . '.php';
   });

   //Sessions
   session_start();

   //Pages autorisées
   $authPages = array('article', '404', 'admin/index', 'admin/add', 'admin/viewArticles', 'admin/config', 'admin/valide');

   $controleur;

   //Page demandée
   //Si on demande une page et qu'elle est authorisée, OK.  Sinon-> index.
   $controleur = (isset($_GET['controleur'])) ? ((in_array($_GET['controleur'], $authPages)) ? $_GET['controleur'] : '404') : 'index';
try{
    //Vérification du fichier
    if(!is_file('Controleur/'.$controleur.'.php'))
            throw new BadMethodCallException('Contrôleur non existant: «'.$controleur.'»');
    //Chargement du contrôleur
    require_once('Controleur/'.$controleur.'.php');
}catch(Exception $e){
    include_once('Controleur/Exceptions.php');
}

