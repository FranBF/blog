<?php
namespace App\Controllers;
use App\Controller;
use App\Model;
use App\View;
use App\Request;
use App\Session;

class PostController extends Controller implements View,Model{

    public function __construct(Request $request, Session $session){
        parent::__construct($request,$session);
    }

    public function index(){
        $dataview=['post',['title'=>'post']];
        $this->render($dataview);
    }

    public function insert(){
        $user=$this->session->get('id');
        $title = filter_input(INPUT_POST, 'title');
        $content = filter_input(INPUT_POST, 'content');
        $category = filter_input(INPUT_POST, 'category');
        $tag = filter_input(INPUT_POST, 'tag');
        $db=$this->getDB();
        $post = $db->insertPost($user, $title, $content, $category, $tag);
        $iid = $db->lastInsertId();
        if(isset($iid)){
            header('Location:'.BASE);
        }
        $post2 = $db->insertTag($tag);
    }

    
}