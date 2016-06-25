<!-- Juste pour info, j'ai piqué ce code à un autre de mes projets (vive la réutilisation :P)
     D'où les commentaires en anglais ou lieu du français, et la présence de Bootstrap-->
<!-- Pour info, voici l'idée qui se cache derrière ce code:
    Je souhaitais afficher une pagination avec un bouton «Précédent» et un bouton «Suivant».
    Seulement, comme ce site pouvait avoir… des milliers de pages (enfin, je l'espère…), je voulais que la pagination s'adapte selon les circonstances. 
    L'idée est donc d'affiche les 2 pages précédentes et les deux pages suivantes. 
    Il faut donc tester si on peut afficher les pages précédentes ($page > 2)
    Et si on peut afficher les deux pages suivantes ($page < ($nbPages -2))
    Avec les variations «et s'il n'y a qu'une page?  Et les boutons «Précédent» et «Suivant»?
    Voilà voilà…
    Si vous le souhaitez, je peux vous envoyer le code original :)
    Ah… j'oubliais… Le HTML est piqué de la doc Bootstrap :P
    -->
<div class="row">
    <div class="controls-fixed col-md-2 col-md-offset-5">
        <ul class="pagination" id="pagination">
            <!-- Preparing variable for next page -->
            <?php $nextAvailable = false;
            //If more than one page AND not the first
            if($nbPages == 1 || $page == 1){ ?>
                <li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
            <?php }
            else{ ?>
                <li><a href="index.php?page=<?php echo ($page-1); ?>" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
            <?php } ?>
            <!-- If pagination too big, we're not showing all -->
            <?php if($page > 2){ ?>
                <!-- We show two previous pages, no more -->
                <li><a href="<?php echo 'index.php?page='.($page-2); ?>"><?php echo ($page -2); ?></a></li>
                <li><a href="<?php echo 'index.php?page='.($page-1); ?>"><?php echo ($page -1); ?></a></li>
                <li class="active"><a href="#"><?php echo $page; ?><span class="sr-only">(current)</span></a></li>
            <?php }
            else{ ?>
                <!-- We are not at page 3 or more -->
                <!-- We show every previous page -->
                <?php if($page == 2){ ?>
                    <li><a href="index.php?page=1">1</a></li>
                <?php } ?>
                <!-- Current page -->
                <li class="active"><a href="#"><?php echo $page; ?></a></li>
            <?php } //fin du «else ($page > 2) ?>
            <!-- Next pagination -->
            <!-- We check if next page exist two times -->
            <?php if($nbPages >= ($page+1)){ ?>
                <li><a href="index.php?page=<?php echo ($page+1); ?>"><?php echo ($page +1); ?></a></li>
                <?php $nextAvailable = true;
            }
            if($nbPages >= ($page+2)){ ?>
                <li><a href="index.php?page=<?php echo ($page+2); ?>"><?php echo ($page +2); ?></a></li>
            <?php }
            //If next page is available, we activate the button
            if($nextAvailable){ ?>
                <li>
                    <a href="index.php?page=<?php echo ($page+1); ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php }
            else{ ?>
                <li class="disabled">
                    <a href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>