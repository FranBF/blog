<?php
namespace App\Controllers;
use App\Controller;
use App\Model;
use App\View;
use App\Request;
use App\Session;
use App\DB;

class RegisterController extends Controller implements View,Model{

    public function __construct(Request $request, Session $session){
        parent::__construct($request, $session);
    }

    public function index(){
        $dataview=['register',['title'=>'register']];
        $this->render($dataview);
    }

    public function reg(){
        $email = filter_input(INPUT_POST, 'email');
        $username = filter_input(INPUT_POST, 'username');
        $pass = filter_input(INPUT_POST, 'pass');
        $db=$this->getDB();
        $register = $db->register($email, $username, $pass);
        $idd = $db->lastInsertId();
        if(isset($idd)){
            header('Location:'.BASE);
        }
    }
}