<h1>Articles publiés</h1>
<?php
if($listeArticles === FALSE){ ?>
    <p>Désolé, aucun article n'existe</p>
    <p>Vous pouvez toujours <a href="index.php?controleur=admin/add">en rédiger un</a></p>
    <?php 
}
else{
    ?>
    <table id="admin-table">
        <tr>
            <th>Titre</th>
            <th colspan="2">Action</th>
        </tr>
    <?php
    foreach($listeArticles as $article){
        ?>
        <tr>
            <td><?= $article['titre']; ?></td>
            <td>
                <a href="index.php?controleur=admin/add&amp;id=<?= $article['id']; ?>&amp;token=<?= $code; ?>" class="btn btn-default"><span class="glyphicon glyphicon-edit"></span></a>
            </td>
            <td>
                <a href="index.php?controleur=admin/add&amp;id=<?= $article['id']; ?>&amp;action=delete&amp;token=<?= $code; ?>" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></a>
            </td>
        </tr>
        <?php
        }
    ?>
    </table>
<?php } ?>
