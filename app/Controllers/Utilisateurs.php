<?php 
namespace App\Controllers;
use App\Models\UtilisateurModel;
use CodeIgniter\Controller;

class Utilisateurs extends Controller
{

    
    // show users list
    public function list(){
        $utilisateurModel = new UtilisateurModel();
        $data['utilisateurs'] = $utilisateurModel->where('deleted_at',null)->orderBy('id', 'DESC')->findAll();
        return view('utilisateurs_view', $data);
    }

    // add user form
    public function new(){
        $data = [
            'nom' => "",
            'prenom' => "",           
            'email'  => "",
            'mdp'  => ""
            
        ];
        return view('new_utilisateur_view',$data);
    }
 
    // insert data
    public function create() {
        $utilisateurModel = new UtilisateurModel();
        $this->session = service('session');
        $data = [
            'nom' => esc($this->request->getPost('nom')),
            'prenom' => esc($this->request->getPost('prenom')),
            'email'  => esc($this->request->getPost('email')),
            'mdp'  => esc($this->request->getPost('mdp')),
            
        ];

        $rule = [
            
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|valid_email|is_unique[t_utilisateurs.email]',
            'mdp' => 'required|min_length[8]|regex_match[/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/])'

        ];


        $error = [   // Errors
            'nom' => [
                'required' => 'Vous devez préciser un nom.',
            ],
            'prenom' => [
                'required' => 'Vous devez préciser un prénom.',
            ],
            'email' => [
                'required' => 'Vous devez préciser un email.',
                'valid_email' => 'Vous devez préciser un email valide.',
                'is_unique' => 'Un utilisateur existe déjà avec ce mail',
            ],
            'mdp' => [
                'required' => 'Vous devez préciser un mot de passe.',
                'min_length' => 'Vous devez préciser un mot de passe de 8 caractères minimum.',
                'regex_match' => 'Vous devez préciser un mot de passe avec une minuscule, une majuscule, un chiffre et un caractère spécial.',
            ],

            ];

        if (! $this->validateData($data, $rule, $error)) {
            
            $this->session->setFlashdata(['res'=>false,'message'=>'Il ya des erreurs de saisie']);
            $data['errors'] = $this->validator->getErrors();
            return view('new_utilisateur_view',$data);
            
        }

        // Hash Password

        $hashPassword = password_hash($data['mdp'], PASSWORD_DEFAULT); 

        $data['mdp']= $hashPassword;
        

        $utilisateurModel->insert($data);
        $this->session->setFlashdata(['res'=>true,'message'=>'L\'utilisateur a été créé avec succès.']);
        return $this->response->redirect(site_url("/Utilisateurs/list"));
    }

    // show single user
    public function edit($id = null){
        $utilisateurModel = new UtilisateurModel();
        $data = $utilisateurModel->where('id', $id)->first();
        return view('edit_utilisateur_view', $data);
    }

 

    // update user data
    public function update(){
        $utilisateurModel = new UtilisateurModel();
        $this->session = service('session');
        $id = esc($this->request->getPost('id'));
        $data = [
            'id' => esc($this->request->getPost('id')),
            'nom' => esc($this->request->getPost('nom')),
            'prenom' => esc($this->request->getPost('prenom')),
            'email'  => esc($this->request->getPost('email')),
        ];

        $rule = [
            
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|valid_email|is_unique[t_utilisateurs.email]',
            

        ];


        $error = [   // Errors
            'nom' => [
                'required' => 'Vous devez préciser un nom.',
            ],
            'prenom' => [
                'required' => 'Vous devez préciser un prénom.',
            ],
            'email' => [
                'required' => 'Vous devez préciser un email.',
                'valid_email' => 'Vous devez préciser un email valide.',
                'is_unique' => 'Un utilisateur existe déjà avec ce mail',
            ],
            

        ];

        if (! $this->validateData($data, $rule, $error)) {
            
            
            $this->session->setFlashdata(['res'=>false,'message'=>'Il ya des erreurs de saisie']);
            $data['errors'] = $this->validator->getErrors();
            return view('edit_utilisateur_view',$data);
            
        }
        $utilisateurModel->update($id,$data);
        $this->session->setFlashdata(['res'=>true,'message'=>'L\'utilisateur a été sauvé avec succès.']);
        return $this->response->redirect(site_url('/Utilisateurs/list'));

        
    }
 
    // delete user
    public function delete($id = null){
        $utilisateurModel = new UtilisateurModel();

        $this->session = service('session');

        //$data['utilisateur'] = $utilisateurModel->where('id', $id)->delete($id);
        
        if ($utilisateurModel->where('id', $id)->delete($id)) 
        {
            
            $this->session->setFlashdata(['res'=>true,'message'=>'L\'utilisateur a été supprimé ']);
            return $this->response->redirect(site_url("/Utilisateurs/list"));
        }
        else
        {
            $this->session->setFlashdata(['res'=>false,'message'=>'L\'utilisateur n\'a pas pu être supprimé ']);
            return $this->response->redirect(site_url("/Utilisateurs/list"));

        }
        
        
    }    
}