<?php
namespace App\Controllers;
use App\Controller;
use App\Model;
use App\View;
use App\Request;
use App\Session;
use App\DB;

class AccountController extends Controller implements View,Model{

    public function __construct(Request $request, Session $session){
        parent::__construct($request, $session);
    }

    public function index(){
        $email=$this->session->get('id');
        $db=$this->getDB();
        $posts = $db->selectPosts($email);
        
        $this->render(['posts'=>$posts, 'email'=>$email], 'account');
    }

    public function seeC(){
        //$user=$this->session->get('id');
        $db=$this->getDB();
        $select = $db->selectComm();
    }
}