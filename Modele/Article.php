<?php

/**
 * Cette classe représente l'entité «Article»
 */
class Article extends Entity{
    
    /**
     * Constructeur
     * Initialise les variables
     */
    public function __construct($data = array()){
        if(!empty($data)){
            $this->hydrate($data);
        }
        //Pas de données -> données par défaut
        else{
            $this->id = -1;
            $this->auteur = '';
            $this->titre = '';
            $this->date = new \DateTime();
            $this->contenu = '';
        }
    }
     
     public function getId(){
         return $this->id;
     }
     
     protected function setId($id){
         //«protected» parce qu'on ne peut pas toucher à ça
         $this->id = $id;
     }
     
     public function getTitre(){
         return $this->titre;
     }
     
     public function setTitre($titre){
         $this->titre = $titre;
     }
     
     public function getAuteur(){
         return $this->auteur;
     }
     
     public function setAuteur($auteur){
         $this->auteur = $auteur;
     }
     
     public function getContenu(){
         return $this->contenu;
     }
     
     public function setContenu($contenu){
         $this->contenu = $contenu;
     }
     
     public function getDate(){
         return $this->date;
     }
     
     protected function setDate($date){
         //Également «protected» parce que la date n'est pas modifiable
         $this->date = ($date instanceof DateTime) ? $date : new DateTime($date);
     }
    
    // Attributs
    private $id;
    private $titre;
    private $auteur;
    private $contenu;
    private $date;
}
