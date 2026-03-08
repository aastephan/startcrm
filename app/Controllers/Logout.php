<?php 

namespace App\Controllers;  
use CodeIgniter\Controller;

  

class Logout extends Controller
{
    public function index()
    {
        
        $this->session = service('session');

        //destroy. session

        $this->session->destroy();

           
        return redirect()->to('/Login');
       
    } 
  
   
}
