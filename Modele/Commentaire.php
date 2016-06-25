<?php
/**
 * Cette classe représente l'entité «Commentaire» 
 */

class Commentaire extends Entity{
    
    /**
     * Constructeur
     * @param Article $article Objet «Article» auquel appartient le commentaire
     * @param array $data Données du commentaire
     */
    public function __construct($article, $data = array()){
        //On demande un objet Article pour s'épargner le besoin de vérifier la validité de l'ID.  Ce sera fait pour nous :)
        if(!$article instanceof Article)//if(!is_numeric($article))
            throw new InvalidArgumentException('Un Article était attendu…');
        //Hydrateur
        if(!empty($data)){
            $this->hydrate($data);
        }
        else{
            $this->id = -1;
            $this->auteur = '';
            $this->email = '';
            $this->message = '';
            $this->avatar = '<img src="Vue/chindit.jpg" alt="Default Avatar" width="40px">'; //Avatar par défaut
            $this->date = new DateTime();
            $config = Config::getInstance();
            $this->valide = $config->getConfig('publish_commentaires');
        }
        
        //Dans tous les cas, l'article est valide (vérifié dans d'autres classe)
        $this->article = $article->getId();
    }
    
    //Setters et getters
    public function getId(){
        return $this->id;
    }
    
    protected function setId($id){
        $this->id = $id;
    }
    
    public function getArticle(){
        return $this->article;
    }
    
    public function setArticle($article){
        $this->article = $article;
    }
    
    public function getAuteur(){
        return $this->auteur;
    }
    
    public function setAuteur($auteur){
        $this->auteur = $auteur;
    }
    
    public function getEmail(){
        return $this->email;
    }
    
    public function setEmail($email){
        $this->email = $email;
        //Mise en place du Gravatar si l'email est valide
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $this->setAvatar($this->getGravatar($email, 40, 'mm', 'x', true, array('width' => "40px")));
        }
    }
    
    public function getMessage(){
        return $this->message;
    }
    
    public function setMessage($message){
        $this->message = $message;
    }
    
    public function getDate(){
        return $this->date;
    }
    
    protected function setDate($date){
        $this->date = ($date instanceof DateTime) ? $date : new DateTime($date);
    }
    
    public function getAvatar(){
        return $this->avatar;
    }
    
    public function setAvatar($avatar){
        $this->avatar = $avatar;
    }
    
    public function getValide(){
        return $this->valide;
    }
    
    public function setValide($valide){
        $this->valide = $valide;
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
        $url .= "?s=$s&d=$d&r=$r&d=https://user.oc-static.com/files/86001_87000/86307.jpg"; //Image par défaut -> la mienne
        if ( $img ) {
            $url = '<img src="' . $url . '"';
            foreach ( $atts as $key => $val )
                $url .= ' ' . $key . '="' . $val . '"';
            $url .= ' />';
        }
        return $url;
    }
    
    //ATTRIBUTS
    private $id;
    private $article;
    private $auteur;
    private $email;
    private $message;
    private $date;
    private $avatar;
    private $valide;
}
?>
