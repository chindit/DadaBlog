<h3>Ajouter un nouvel article</h3>
<!--ALERTE-->
<?php require_once('Vue/alertes.php'); ?>
<!--FORMULAIRE-->
<form method="post" action="index.php?controleur=admin/add<?php if($iee){ echo '&amp;id='.$article->getId(); } ?>">
    <div class="block">
        <label for="titre">Titre</label>
        <input type="text" name="titre" maxlenght="150" <?php if($iee){ echo 'value="'.$article->getTitre().'" '; } ?>required>
    </div>
    <div class="block">
        <label for="contenu">Contenu</label><br>
        <textarea name="contenu" rows="10" cols="75" required><?php
            if($iee){
                echo $article->getContenu();
            }
            ?></textarea>
    </div>
    <input type="hidden" name="csrf" value="<?= $code; ?>">
    <input type="submit" name="submit">
</form>
