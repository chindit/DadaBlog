<?php
/**
 * Classe «Commentaire»
 * Gère tout ce qui a trait aux commentaires
 */

class CommentaireModele{
    /**
     * Constructeur 
     * @param int $id : ID de l'article
     */
    public function __construct(){
        $sql = Sql::GetInstance();
        $this->bdd = $sql->getPDO();
    }
    
    /**
     * Récupère tous les commentaires d'un article
     * @param int $id : ID de l'article
     * @return array : commentaires
     */
     public function getComments($article){
         $query = $this->bdd->prepare('SELECT * FROM commentaires WHERE article=:id AND valide=1');
         $aId = $article->getId();
         $query->bindParam('id', $aId, PDO::PARAM_INT);
         $query->execute();
         $result = $query->fetchAll(PDO::FETCH_ASSOC);
         
         $commentsList = $this->mkCommentsList($article, $result);

        //On renvoie la liste des Commentaires
         return $commentsList;
     }
     
     /**
      * Récupère le commentaire dont l'ID est en paramètre
      * @param int $id ID du commentaire
      * @return Commentaire
      */
     public function getComment($id){
         $query = $this->bdd->prepare('SELECT articles.id AS id FROM articles INNER JOIN commentaires ON articles.id=commentaires.article WHERE commentaires.id=:id');
         $query->bindParam('id', $id, PDO::PARAM_INT);
         $query->execute();
         $result = $query->fetch(PDO::FETCH_ASSOC);
        $article = new Article($result); //A cause de la sécurité, on est OBLIGÉ de récupérer l'article
        //Récupération du commentaire
        $query = $this->bdd->prepare('SELECT * FROM commentaires WHERE id=:id');
        $query->bindParam('id', $id, PDO::PARAM_INT);
         $query->execute();
         $result = $query->fetch(PDO::FETCH_ASSOC);
         if($result === FALSE)
            throw new Exception('Le commentaire n\'existe pas!');
        $commentaire = new Commentaire($article, $result);
        return $commentaire;
     }
      
      /**
       * Enregistre le commentaire
       * @param Commentaire $commentaire Le commentaire à enregistrer
       * @return bool
       */
      public function save($commentaire){
          if(!$commentaire instanceof Commentaire){
             throw new InvalidArgumentException('Un Commentaire était attendu…');
        }
        
        $query;
        
        //Commentaire valide
        if($commentaire->getId() < 0){
            //INSERT -> pour éviter les «E_NOTICE», je transfère dans un array
            $query = $this->bdd->prepare('INSERT INTO commentaires(article,auteur,email,message,valide) VALUES( :article, :auteur, :email, :message,:valide)');
        }
        else{
            //UPDATE
            $query = $this->bdd->prepare('UPDATE commentaires SET article=:article, auteur=:auteur, email=:email, message=:message, valide=:valide WHERE id=:id');
            $commId = $commentaire->getId();
            $query->bindParam('id', $commId, PDO::PARAM_INT);
        }
        $sqlData = array('article' => $commentaire->getArticle(),
                                                'auteur' => $commentaire->getAuteur(),
                                                'email' => $commentaire->getEmail(),
                                                'message' => $commentaire->getMessage(),
                                                'valide' => $commentaire->getValide());
          $query->bindParam('article', $sqlData['article'], PDO::PARAM_INT);
            $query->bindParam('auteur', $sqlData['auteur'], PDO::PARAM_STR);
            $query->bindParam('email', $sqlData['email'], PDO::PARAM_STR);
            $query->bindParam('message', $sqlData['message'], PDO::PARAM_STR);
            $query->bindParam('valide', $sqlData['valide'], PDO::PARAM_INT);
            return $query->execute();                                      
      }
      
      /**
       * Supprime un commentaire
       * @param Commentaire $commentaire Le commentaire à supprime
       * @return bool
       */
      public function delete($commentaire){
        if(!$commentaire instanceof Commentaire)
             throw new InvalidArgumentException('Un Commentaire était attendu…');
        $query = $this->bdd->prepare('DELETE FROM commentaires WHERE id=:id');
        $id = $commentaire->getId();
        $query->bindParam('id', $id, PDO::PARAM_INT);
        return $query->execute();
      }
      
      /**
       * Renvoie la liste des commentaires non validés
       * @return array of Commentaires
       */
      public function getUnpublishedComments(){
          $query = $this->bdd->query('SELECT * FROM commentaires WHERE valide=0 ORDER BY date ASC');
          $listeComments = $query->fetchAll(PDO::FETCH_ASSOC);
          return $listeComments;
      }
      
      /**
     * Get either a Gravatar URL or complete image tag for a specified email address.
     *
     * @param string $email The email address
     * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
     * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
     * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
     * @param bool $img True to return a complete IMG tag False for just the URL
     * @param array $atts Optional, additional key/value attributes to include in the IMG tag
     * @return String containing either just a URL or a complete image tag
     * @source http://gravatar.com/site/implement/images/php/
     */
    private function getGravatar( $email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
        $url = 'http://www.gravatar.com/avatar/';
        $url .= md5( strtolower( trim( $email ) ) );
        $url .= "?s=$s&d=$d&r=$r&d=https://user.oc-static.com/files/86001_87000/86307.jpg";
        if ( $img ) {
            $url = '<img src="' . $url . '"';
            foreach ( $atts as $key => $val )
                $url .= ' ' . $key . '="' . $val . '"';
            $url .= ' />';
        }
        return $url;
    }
    
    /**
     * Crée un array de «Commentaires» 
     * @param array $fetched Résultat de fetchAll
     */
    private function mkCommentsList($article, $fetched){
        $commentsList = array();
         foreach($fetched as $commentLoop){
             $commentEntity = new Commentaire($article, $commentLoop);
             $commentsList[] = $commentEntity;
         }
         return $commentsList;
    }
      
    private $bdd;
}
