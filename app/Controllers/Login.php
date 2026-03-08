<?php 

namespace App\Controllers;  
use CodeIgniter\Controller;
use App\Models\UtilisateurModel;
  

class Login extends Controller
{
    public function index()
    {
       helper(['form']);
       echo view('login_view');
    } 
  
    public function Authentification()
    {
        //$session = session();
        $this->session = service('session');

        $utilisateurModel = new UtilisateurModel();

        $email = esc($this->request->getPost('email'));
        $password = esc($this->request->getPost('password'));
        
        $data = $utilisateurModel->where('email', $email)->first();
        
        if($data){
            $pass = $data['mdp'];
            $authenticatePassword = password_verify($password, $pass);
            if($authenticatePassword){
                $session_data = [
                    'id' => $data['id'],
                    'nom' => $data['nom'],
                    'prenom' => $data['prenom'],
                    'email' => $data['email'],
                    'isLoggedIn' => TRUE
                ];

                $this->session->set($session_data);
                return redirect()->to('Accueil');
            
            }else{

                $this->session->setFlashdata(['res'=>false,'message'=>'Mot de passe incorrect']);                
                return redirect()->to('/Login');
            }

        }else{

            $this->session->setFlashdata(['res'=>false,'message'=>'Ce login n\'existe pas']);
           
            return redirect()->to('/Login');
           
        }
    }
}
