<?php
namespace App\Controllers;
use App\Controller;
use App\Model;
use App\View;
use App\Request;
use App\Session;

class BuscarController extends Controller implements View,Model{

    public function __construct(Request $request, Session $session){
        parent::__construct($request,$session);
    }

    public function index(){
        $tag = filter_input(INPUT_POST, 'tag');
        $db=$this->getDB();
        $task = $db->selectAllTask($tag);
        $this->render(['title'=>'buscar', 'postT'=>$task], 'buscar');
    }
}