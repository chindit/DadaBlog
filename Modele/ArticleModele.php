<?php

class ArticleModele{
    /**
     * Constructeur
     * Instancie la connexion à la BDD
     */
    public function __construct(){
        $sql = Sql::GetInstance();
        $this->bdd = $sql->getPDO();
        $this->nbPages = -1;
    }
    
    /**
     * Enregister un article
     * @param Article  $article Article à sauvegarder
     * @return bool
     */
    public function save($article){
        if(!$article instanceof Article)
            throw new  InvalidArgumentException('Un Article était attendu…');
        
        $sqlData = array('titre' => $article->getTitre(),
                                            'auteur' => $article->getAuteur(),
                                            'contenu' => $article->getContenu());
        $query;
        if($article->getId() < 0){
            //INSERT -> pour éviter les «E_NOTICE», je transfère dans un array
            $query = $this->bdd->prepare('INSERT INTO articles(titre,contenu,auteur) VALUES( :titre,:contenu,:auteur)');
        }
        else{
            //L'ID existe déjà -> UPDATE
            $query = $this->bdd->prepare('UPDATE articles SET titre=:titre, contenu=:contenu, auteur=:auteur WHERE id=:id');
            $sqlData['id'] = $article->getId();
            $query->bindParam('id', $sqlData['id'], PDO::PARAM_INT);
        }
        $query->bindParam('titre', $sqlData['titre'], PDO::PARAM_STR);
        $query->bindParam('contenu', $sqlData['contenu'], PDO::PARAM_STR);
        $query->bindParam('auteur', $sqlData['auteur'], PDO::PARAM_STR);
        return $query->execute();
    }
    
    /**
     * Supprime un article
     * @param Article $article Article à supprimer
     * @return bool
     */
    public function delete($article){
        if(!$article instanceof Article)
             throw new InvalidArgumentException('Un Article était attendu…');
        //D'abord on vire les commentaires
        $query = $this->bdd->prepare('DELETE FROM commentaires WHERE article=:article');
        $query2 = $this->bdd->prepare('DELETE FROM articles WHERE id=:id');
        $id = $article->getId();
        $query->bindParam('article', $id, PDO::PARAM_INT);
        $query2->bindParam('id', $id, PDO::PARAM_INT);
        $query->execute();
        return $query2->execute();
      }
    
    /**
     * Renvoie la liste des articles pour l'administration
     * @return array
     */
    public function getArticlesList(){
        $query = $this->bdd->query('SELECT id,titre FROM articles ORDER BY date DESC');
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Vérifie si le nombre donné est valide et correspond bien à une page 
     * @param int $page
     * @return bool
     */
    public function isPageInRange($page){
        //1)Nombre de pages?
        $nbPages = $this->getNbPages();
        //2)Renvoi de la valeur
        return ($page > 0 && $page <= $nbPages) ? true : false;
    }
    
    /**
     * Récupère un article en particulier
     * @param int $id
     * @return array : article
     */
     public function getArticle($id){
		 $query = $this->bdd->prepare('SELECT * FROM articles WHERE id=:id');
		 $query->bindParam('id', $id, PDO::PARAM_INT);
		 $query->execute();
         $articleData = $query->fetch(PDO::FETCH_ASSOC);
         if($articleData === FALSE)
            throw new Exception('L\'article demandé n\'existe pas!');
        
        $articleEntity = new Article($articleData);
        return $articleEntity;
	 }
    
    /**
     * Calcule le nombre de pages
     * @return int : nombre de pages
     */
    public function getNbPages(){
        //Si on a déjà compté, on ne recompte pas.
        if($this->nbPages > 0)
            return $this->nbPages;
        //Comptage des articles
        $nbArticles = $this->bdd->query('SELECT COUNT(id) AS nbItems FROM articles')->fetch()[0];
        $this->nbPages = ceil($nbArticles/$this->nbItemsPage);
        //Renvoi du nombre de pages 
        return $this->nbPages;
    }
    
    /**
     * Renvoie les articles de la page demandée
     * @param int $page : nombre de pages 
     * @return array : liste des articles
     */
    public function getPage($page){
        //Sélection des données
        $query = $this->bdd->prepare('SELECT id,auteur,titre,CONCAT(LEFT(contenu, 500), \'…\')AS contenu,date FROM articles ORDER BY date DESC  LIMIT :start, :limit');
        //Page -1 étant donnée que Page 1 = Articles 0
        $start = ($page-1)*$this->nbItemsPage;
        $query->bindParam('start', $start, PDO::PARAM_INT);
        $query->bindParam('limit', $this->nbItemsPage, PDO::PARAM_INT);
        $query->execute();
        //Même si le texte a été tronqué, ce sont quand même des «articles»
        $articlesListData = $query->fetchAll(PDO::FETCH_ASSOC);
        $articlesList = array();
        //On crée les objets et on les renvoie
        foreach($articlesListData as $articleData){
            $currentArticle = new Article($articleData);
            $articlesList[] = $currentArticle;
        }
        //On renvoie la liste des articles
        return $articlesList;
    }
    
    private $bdd;
    private $nbPages;
    private $nbItemsPage = 5; //Nombre d'éléments (articles) par page
}
