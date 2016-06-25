<?php

class Security{
    
    /**
     * Génère un token unique
     * @return string Token
     */
    public static function generateToken(){
        $chars = '123456789ABCDEFGHIJKLMNPRSTUVWXYZ'; //Q supprimé pour éviter des confusions
        $code = '';
        for ($i=0; $i<25; $i++) {
            $code .= $chars{ mt_rand( 0, strlen($chars) - 1 ) };
        }
        //On ajoute le token à la session
        $_SESSION['token'] = serialize(array('code' => $code, 'generation' => time()));
        return $code;
    }
    
    /**
     * Vérifie la validité du token en entrée
     * @param string $token Token à vérifier
     * @return bool
     */
     public static function isTokenValid($token){
         if(!isset($_SESSION['token']) || !unserialize($_SESSION['token']) || !is_array(unserialize($_SESSION['token'])))
            return false;
        $data = unserialize($_SESSION['token']);
        if(!isset($data['code']) || !isset($data['generation']))
            return false;
        if($data['code'] != $token)
            return false;
        if($data['generation'] < (time() - (15*60)))
            return false;
        //Si on est ici, c'est que tout est bon
        return true;
     }
}
