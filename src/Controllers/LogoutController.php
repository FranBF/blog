<?php
namespace App\Controllers;
use App\Request;
use App\Controller;
use App\Session;

final class LogoutController extends Controller{

    public function __construct(Request $request, Session $session){
        parent::__construct($request, $session);
    }

    public function logout(){
        $this->session->delete('email');
        $this->session->delete('id');
        header('Location:'.BASE);
    }
    
}