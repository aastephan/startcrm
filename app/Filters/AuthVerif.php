<?php 

namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;



class AuthVerif implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {


        try {

            $db = \Config\Database::connect();
        
            if($db->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME='startcrm'"))
            {
                if (!session()->get('isLoggedIn'))
                {
                    //$this->session->setFlashdata(['message'=>'Vous n\'êtes pas connecté(e)']);
                    return redirect()
                        ->to('/Login');
                }
            
            }
            else
            {
    
                return redirect()->to('/Install');
            }
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            echo 'Exception reçue : ',  $e->getMessage(), "\n";
            return redirect()->to('/Install');

        }

        
            
    }
    
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        
    }
}