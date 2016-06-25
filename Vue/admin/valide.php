<?php require_once('Vue/alertes.php'); ?>

<h1>Validation des commentaires</h1>

<table id="admin-table">
    <tr>
        <th>Pseudo</th>
        <th>Commentaire</th>
        <th colspan="2">Action</th>
    </tr>
    <?php
    foreach($listeCommentaires as $comment){
        ?>
        <tr>
            <td><?= $comment['auteur']; ?></td>
            <td><?= $comment['message']; ?></td>
            <td>
                <a href="index.php?controleur=admin/valide&amp;id=<?= $comment['id']; ?>&amp;action=valide&amp;token=<?= $code; ?>" class="btn btn-default"><span class="glyphicon glyphicon-ok"></span></a>
            </td>
            <td>
                <a href="index.php?controleur=admin/valide&amp;id=<?= $comment['id']; ?>&amp;action=delete&amp;token=<?= $code; ?>" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></a>
            </td>
        </tr>
        <?php
        }
    ?>
    </table>
