<?php
    if(empty($articles)){ //Pas d'articles
        echo '<p>Malheureusement votre blog est vide… peut-être serait-il temps de <a href="#">poster quelque chose</a>?</p>';
    }
    else{
        //Affichage des articles
        foreach($articles as $article){
            echo '<article>
                <div class="header">
                    <h6>'.$article->getTitre().'</h6>
                    <span class="auteur">Publié par : '.$article->getAuteur().'</span>
                    <span class="date">'.$article->getDate()->format('d/m/Y H:i:s').'</span>
                </div>
                <div class="contenu">'.$article->getContenu().'</div>
                <div class="more"><a href="index.php?controleur=article&amp;id='.$article->getId().'">Lire plus</a></div>
            </article>';
        }
    }
    include('pagination.php'); 
?>
