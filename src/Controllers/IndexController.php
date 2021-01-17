<?php
namespace App\Controllers;
use App\Request;
use App\Controller;
use App\Session;

final class IndexController extends Controller{

    public function __construct(Request $request, Session $session){
        parent::__construct($request, $session);
    }

    public function index(){
        $email=$this->session->get('email');
        $id=$this->session->get('id');
        $db=$this->getDB();
        $posts = $db->selectAllPosts();
        $comm = $db->selectComm();
        $b = $db->seeBlocks();
        $this->render(['posts'=>$posts, 'email'=>$email, 'comm'=>$comm, "ident"=>$id, "blocks"=>$b], 'index');
    }

    public function delete(){
        $params = $this->request->getParams();
        $email=$this->session->get('id');
        $db=$this->getDB();
        $del = $db->deleteAll(intval($params['id']), $email);
        $id = $db->lastInsertId();
        if(isset($id)){
            header('Location:'.BASE);
        }
    }

    public function block(){
        $user_blocker = $this->session->get('id');
        $params = $this->request->getParams();
        $db=$this->getDB();
        $comm = $db->blockU($user_blocker, $params['id']);
    }

    public function search(){
        $tag = filter_input(INPUT_POST, 'tag');
        $db=$this->getDB();
        $idd = $db->lastInsertId();
        $task = $db->selectAllTask($tag);
        $this->render(['postT'=>$task], 'buscar');
        if(isset($idd)){
            header('Location:'.BASE.'buscar');
        }
    }
    
}