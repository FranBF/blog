<?php
namespace App\Controllers;
use App\Controller;
use App\Model;
use App\View;
use App\Request;
use App\Session;
use App\DB;

class CommentController extends Controller implements View,Model{

    public function __construct(Request $request, Session $session){
        parent::__construct($request, $session);
    }

    public function index(){
        $dataview=['account',['title'=>'account']];
        $this->render($dataview);
    }

    public function insC(){
        $content = filter_input(INPUT_POST, 'comm');
        $user = $this->session->get('id');
        $params = $this->request->getParams();
        $db=$this->getDB();
        $id = $db->lastInsertId();
        if(isset($id)){
            header('Location:'.BASE);
        }
        $comm = $db->insertComment($content, $user, $params['id']);
    }
}