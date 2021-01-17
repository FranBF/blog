<?php

namespace App;
use App\Session;

class DB extends \PDO{
    static $instance;
    protected  $config;

    static function singleton(){
        if(!(self::$instance instanceof self)){
            self::$instance=new self;
        }
        return self::$instance;
    }

    public function __construct(){
        $config=$this->loadConf();
        $strdbconf='dbconf_'.$this->env();
        $dbconf=(array)$config->$strdbconf;
        $dsn=$dbconf['driver'].':host='.$dbconf['dbhost'].';dbname='.$dbconf['dbname'];
        $usr=$dbconf['dbuser'];
        $pwd=$dbconf['dbpass'];
        parent::__construct($dsn, $usr, $pwd);
    }

    private function env(){
        $ipAdrr=gethostbyname($_SERVER['SERVER_NAME']);
        if($ipAdrr=='127.0.0.1'){
            return 'dev';
        }else{
            return 'pro';
        }
    }

    private function loadConf(){
        $file="config.json";
        $json=file_get_contents($file);
        $arrayJson=json_decode($json);
        return $arrayJson;
    }

    public function register($email, $username, $pass){
        try{
            $options=['cost'=>12];
            $pass_h=password_hash($pass, PASSWORD_BCRYPT, $options);
            $sql="INSERT INTO USER(username, email, pwd) VALUES(:name, :email, :pwd)";
            $result=self::$instance->prepare($sql);
            $result->execute(array(":name"=>$username, ":email"=>$email, ":pwd"=>$pass_h));
            Session::set('email', $email);
        }catch(\PDOException $e){
            echo "Error line ".$e->getLine();
        }
    }

    public function login($email, $pass){
        try{
            $sql = "SELECT * FROM USER where email=:email LIMIT 1";
            $result=self::$instance->prepare($sql);
            $result->execute(array(":email"=>$email));
            $count=$result->rowCount();
            $row=$result->fetchAll(\PDO::FETCH_ASSOC);
            if($count==1){
                $user=$row[0];
                $res=password_verify($pass, $user['pwd']);
                $id = $user['id_user'];
                if($pass == $res){
                    Session::set('id', intval($id));
                    Session::set('email', $email);
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
            
        }catch(\PDOException $e){
            return "NO ha podido iniciar sesion";
        }
    }

    public function insertPost($user, $title, $content, $category, $tag){
        try{
            $sql="INSERT INTO POST(title, content, user, created, category, tag) VALUES (:title, :content, :user, NOW(), :category, :tag)";
            $result = self::$instance->prepare($sql);
            $result->execute(array(":title"=>$title, ":content"=>$content, ":user"=>$user, ":category"=>$category, ":tag"=>$tag));
            $count=$result->rowCount();
            $row=$result->fetchAll(\PDO::FETCH_ASSOC);
            var_dump($user);
            //die;
            return $row;
        }catch(\PDOException $e){
            return "NO se ha podido publicar";
        }
    }

    public function insertTag($tag){
        try{
            $sql = "INSERT INTO TAGS(tag_name) VALUES(:tag_name)";
            $result = self::$instance->prepare($sql);
            $result -> execute(array(":tag_name"=>$tag));

            $row=$result->fetchAll(\PDO::FETCH_ASSOC);
            $count=$result->rowCount();
            return $row;
        }catch(\PDOException $e){
            return "NO se ha podido publicar";
        }
    }

    public function insertComment($content, $id_user_com, $id_post){
        try{
            $sql="INSERT INTO COMMENT(content_comm, id_user_comm, post_id_comm) VALUES (:content_comm, :id_user_comm, :post_id_comm)";
            $result=self::$instance->prepare($sql);
            $result->execute(array(":content_comm"=>$content, ":id_user_comm"=>$id_user_com, ":post_id_comm"=>$id_post));
            $count=$result->rowCount();
            $row=$result->fetchAll(\PDO::FETCH_ASSOC);
            return $row;
        }catch(\PDOException $e){
            return "NO se ha podido publicar";
        }
    }

    public function selectPosts($user){
        if(isset($user)){
            try{
                $sql="SELECT id_post, user, content, title, created, category, tag FROM POST WHERE user=:user";
                $result=self::$instance->prepare($sql);
                $result -> execute(array(":user"=>$user));
                $row=$result->fetchAll(\PDO::FETCH_ASSOC);
                return $row;
            }catch(\PDOException $e){
                return "No hay nada";
            }
         }else{
            return "Inicia sesion";
        }
    }

    public function selectAllPosts(){
        try{
            $sql="SELECT id_post, user, content, title, created, category, tag FROM POST";
            $result=self::$instance->prepare($sql);
            $result -> execute();
            $row=$result->fetchAll(\PDO::FETCH_ASSOC);
            return $row;
        }catch(\PDOException $e){
            return "No hay nada";
        }
    }

    public function selectComm(){
        $sql="SELECT post_id_comm, content_comm, id_user_comm FROM COMMENT";
        $result=self::$instance->prepare($sql);
        $result ->execute();
        $row=$result->fetchAll(\PDO::FETCH_ASSOC);
        return $row;
    }

    public function deleteAll($id_post, $user){
        $sql = "DELETE FROM POST WHERE id_post=:id_post AND user=:user";
        $result=self::$instance->prepare($sql);
        $result -> execute(array(":id_post"=>$id_post, ":user"=>$user));
        $row=$result->fetchAll(\PDO::FETCH_ASSOC);
        return $row;
    }

    public function blockU($user_blocker, $user_blocked){
        $sql = "INSERT INTO BLOCKS (id_user_blocker, username_blocked) VALUES (:id_user_blocker, :username_blocked)";
        $result = self::$instance->prepare($sql);
        $result->execute(array(":id_user_blocker"=>$user_blocker, ":username_blocked"=>$user_blocked));
        $row=$result->fetchAll(\PDO::FETCH_ASSOC);
        return $row;
    }

    public function seeBlocks(){
        $sql = "SELECT ALL FROM BLOCKS";
        $result = self::$instance->prepare($sql);
        $result->execute();
        $row=$result->fetchAll(\PDO::FETCH_ASSOC);
        return $row;
    }

    public function selectAllTask($tag){
        $sql = ("SELECT * FROM POST WHERE tag=:tag");
        $result = self::$instance->prepare($sql);
        $result -> execute(array(":tag"=>$tag));
        $row=$result->fetchAll(\PDO::FETCH_ASSOC);
        return $row;
    }
}