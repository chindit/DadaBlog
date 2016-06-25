<?php

if(isset($_SESSION['alertes'])){
    $listeAlertes = unserialize($_SESSION['alertes']);
    foreach($listeAlertes as $alerte){
        ?>
        <p class="<?= $alerte[0]; ?>"><?= $alerte[1]; ?></p>
        <?php
    }
}
unset($_SESSION['alertes']);
