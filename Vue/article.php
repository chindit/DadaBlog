<?php
/** 
 * Article.php
 * Gère l'affichage d'un article en particulier
 * En fait… c'est le même code que «index.php» sans le lien.
 * MAIS! Étant donnée que cette page peut être customisée, elle a son template particulier.
 * En prime, on rajoute les commentaires
*/
?>

<article>
    <div class="header">
        <h6><?php echo $article->getTitre(); ?></h6>
        <span class="auteur">Publié par : <?php echo $article->getAuteur() ?></span>
        <span class="date"><?php echo $article->getDate()->format('d/m/Y H:i:s'); ?></span>
    </div>
    <div class="contenu"><?php echo $article->getContenu(); ?></div>
</article>
<aside>
    <?php
        //Affichage des commentaires
        if(empty($comments))
            echo '<p>Aucun commentaire pour cet article</p>';
        else{
            foreach($comments as $item){
                ?>
                <div class="commentaire">
                    <span class="avatar"><?= $item->getAvatar(); ?></span>
                    <span class="auteur">Par: <?= ((empty($item->getAuteur())) ? 'Anonyme' : $item->getAuteur()); ?></span>
                    <span class="date"><?= $item->getDate()->format('d/m/Y H:i:s'); ?></span>
                    <div class="contenu"><?= $item->getMessage(); ?></div>
                    </div>
                <?php
            }//Fin foreach
        }//Fin «if» commentaires
        
        //Affichage des alertes
        require_once('Vue/alertes.php');
    ?>
    <section class="comment_form">
        <h4>Ajouter un commentaire</h4>
        <form method="post" action="index.php?controleur=article&amp;id=<?= $article->getId(); ?>">
            <label for="pseudo">Pseudo</label>
            <input type="text" name="pseudo" maxlength="50" placeholder="Votre pseudo">
            <label for="email">Email (restera confidentiel)</label>
            <input type="email" name="email" placeholder="vous@fai.com">
            <label for="commentaire">Commentaire</label>
            <textarea rows="15" name="message" cols="75" required></textarea>
            <div class="controls">
                <input type="reset" value="Remettre à zéro">
               <input type="submit" name="submit" value="Envoyer">
            </div> 
        </form>
    </section>
</aside>
