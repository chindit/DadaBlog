<h1>Administration de DadaBlog</h1>
<h3>Que souhaitez-vous faire?</h3>
<?php
require_once('Vue/alertes.php');
?>
<ol>
    <li><a href="index.php?controleur=admin/add">Ajouter une news</a></li>
    <li><a href="index.php?controleur=admin/viewArticles">Modifier/Supprimer une news</a></li>
    <li>Gérer les commentaires
        <ol>
            <li><a href="index.php?controleur=admin/config">Options des commentaires</a></li>
            <li><a href="index.php?controleur=admin/valide">Valider des commentaires</a></li>
        </ol>
    </li>
</ol>
