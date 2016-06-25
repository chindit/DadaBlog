<?php require_once('Vue/alertes.php'); ?>

<h1>Options de DadaBlog</h1>

<form method="post" action="index.php?controleur=admin/config">
    <p>Publication des commentaires</p>
    <input type="radio" name="publish_commentaires" id="comments" value="1" <?php if($config->getConfig('publish_commentaires')){ echo 'checked'; } ?>><label for="comments">Autorisée</label><br>
    <input type="radio" name="publish_commentaires" id="no_comments" value="0" <?php if(!$config->getConfig('publish_commentaires')){ echo 'checked'; } ?>><label for="no_comments">Après validation</label><br>
    <input type="hidden" name="csrf" value="<?= $token; ?>">
    <input type="submit" value="Modifier la config" name="submit">
</form>

