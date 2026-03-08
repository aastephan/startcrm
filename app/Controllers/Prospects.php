<?php 
namespace App\Controllers;
use App\Models\EntiteModel;
use CodeIgniter\Controller;

class Prospects extends Controller
{

    public function index(){

    return view('prospects_view');

    }
    
     // show users list
    public function listold(){
        //$source = 0;
        //$selSource = esc($this->request->getPost('selSource'));
        //$selAContacter = esc($this->request->getPost('selAContacter'));

        
        $prospectModel = new EntiteModel();
        /*
        if ($selSource !=0)
        {
            if ($selAContacter == 1)
                $wherearray = ['deleted_at' => null, 'type' => 1,'acontacter' => 1,'source'=>$selSource];
            else
                $wherearray = ['deleted_at' => null, 'type' => 1,'source'=>$selSource];
        }
        else{

            if ($selAContacter == 1)
                $wherearray = ['deleted_at' => null, 'type' => 1,'acontacter' => 1];
            else
                $wherearray = ['deleted_at' => null, 'type' => 1];

            
        }
        */

        
        
        //$data['prospects'] = $prospectModel->where($wherearray)->orderBy('id', 'DESC')->findAll();
        $data['prospects'] = $prospectModel->orderBy('id', 'DESC')->findAll();

        /*
        $data['sources'] = $prospectModel->select('source')->distinct()->orderBy('source ASC')->findAll();
        $data['selSource'] = $selSource;
        $data['selAContacter'] = $selAContacter;
        */

        return view('prospects_view', $data);
    }

      public function list()
{
    $model = new EntiteModel();
    $request = service('request');

    $draw   = intval($request->getPost('draw'));
    $start  = intval($request->getPost('start'));
    $length = intval($request->getPost('length'));
    $search = $request->getPost('search')['value'] ?? '';
    $filter = $request->getPost('selFilter') ?? '0'; // récupère la valeur du select

    $columns = ['id', 'nom', 'ville', 'email'];
    $builder = $model->builder();

    $builder->where('deleted_at', null);
    // ---- FILTRE SELFILTER ----
    if ($filter == '0') {
        // à prospecter : email vide ET contact_via_form = 0
        $builder->where('contacte_via_form', 0);
        $builder->where('email', '');
    } elseif ($filter == '1') {
        // avec mails : email non vide
        $builder->where('email !=', '');
    } elseif ($filter == '2') {
        // contactés : contact_via_form = 1
        $builder->where('contacte_via_form', 1);
    }

    // ---- RECHERCHE GLOBALE ----
    if ($search) {
        $builder->groupStart()
                ->like('nom', $search)
                ->orLike('ville', $search)
                ->orLike('email', $search)
                ->groupEnd();
    }

    // Comptage après filtre
    $totalFiltered = $builder->countAllResults(false);

    // Tri dynamique
    $orderColIndex = intval($request->getPost('order')[0]['column'] ?? 0);
    $orderDir      = $request->getPost('order')[0]['dir'] ?? 'asc';
    $orderCol      = $columns[$orderColIndex] ?? 'id';
    $builder->orderBy($orderCol, $orderDir);

    // Pagination
    $builder->limit($length, $start);
    $prospects = $builder->get()->getResultArray();

    // Génération lignes DataTables
    $data = [];
    foreach ($prospects as $prospect) {
        $row = [];
        $row[] = $prospect['id'];
        $row[] = $prospect['nom'];
        $row[] = $prospect['ville'];
        $row[] = $prospect['email'];

       $buttons = '
    <a href="Prospects/edit/'.$prospect['id'].'" class="btn btn-primary btn-sm">Détail</a>
    <a href="Prospects/delete/'.$prospect['id'].'" class="btn btn-danger btn-sm confirmModalLink">Supprimer</a>
    <a href="https://www.google.com/search?q='.urlencode($prospect['nom'].' '.$prospect['ville']).'" target="_blank" class="btn btn-info btn-sm">GOOGLE</a>
    <button class="btn btn-success btn-sm btn-contacted" data-id="'.$prospect['id'].'">Contacté</button>
    
';
    //<button class="btn btn-sm btn-primary enrich-prospect" data-id="'.$prospect['id'].'">
    //        🔎 Enrichir
    //</button>
        if (!empty($prospect['web'])) {
            $buttons .= ' <a href="'.$prospect['web'].'" target="_blank" class="btn btn-warning btn-sm">SITE WEB</a>';
        }
        $row[] = $buttons;
        $data[] = $row;
    }

    $totalData = $model->countAll();

    return $this->response->setJSON([
        "draw" => $draw,
        "recordsTotal" => $totalData,
        "recordsFiltered" => $totalFiltered,
        "data" => $data,
        "csrfHash" => csrf_hash() // <-- nouveau token
    ]);
}

public function markContacted($id = null)
{
    $model = new \App\Models\EntiteModel();
    $this->session = service('session');

    if (!$id) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'ID invalide',
            "csrfHash" => csrf_hash()
        ]);
    }

    $updated = $model->set('contacte_via_form', 1)
                     ->where('id', $id)
                     ->update();

    return $this->response->setJSON([
        'success' => (bool)$updated,
        'message' => $updated ? 'Prospect marqué comme contacté' : 'Impossible de mettre à jour',
        "csrfHash" => csrf_hash()
    ]);
}



    // add prospect form
    public function new(){
        $data = [
            'profil' => 0,
            'nom' => "",
            'prenom' => "",
            'adresse' => "",
            'cp' => "",
            'ville' => "",
            'pays' => "",
            'tel_fixe'  => "",
            'mobile'  => "",
            'email'  => "",
            'web'  => "",
            'notes'  => ""
            
            
        ];
        
        return view('new_prospect_view',$data);
    }
 
    // insert data
    public function create() {
        $prospectModel = new EntiteModel();
        $this->session = service('session');
        $data = [
            'source' => "SAISIE", // Saisie manuelle
            'type' => 1, // Propspect (client : 2)
            'profil' => esc($this->request->getPost('profil')),
            'nom' => esc($this->request->getPost('nom')),
            'prenom' => esc($this->request->getPost('prenom')),
            'adresse' => esc($this->request->getPost('adresse')),
            'cp' => esc($this->request->getPost('cp')),
            'ville' => esc($this->request->getPost('ville')),
            
            'tel_fixe'  => esc($this->request->getPost('tel_fixe')),
            'mobile'  => esc($this->request->getPost('mobile')),
            'email'  => esc($this->request->getPost('email')),
            'web'  => esc($this->request->getPost('web')),
            'notes'  => esc($this->request->getPost('notes'))
            
        ];

        $rule = [
            
            'nom' => 'required',
            

        ];


        $error = [   // Errors
            
            'nom' => [
                'required' => 'Vous devez préciser un nom.',
            ],
            
            ];

        if (! $this->validateData($data, $rule, $error)) {
            
            $this->session->setFlashdata(['res'=>false,'message'=>'Il ya des erreurs de saisie']);
            $data['errors'] = $this->validator->getErrors();
            return view('new_prospect_view',$data);
            
        }

     

        if ($prospectModel->insert($data))
        {
                $this->session->setFlashdata(['res'=>true,'message'=>'Le prospect a été créé avec succès.']);
                return $this->response->redirect(site_url("/Prospects"));
        }
        else
        {
            $this->session->setFlashdata(['res'=>false,'message'=>'Le prospect n\'a pas pu être créé ']);
            return view('new_prospect_view',$data);
        }
    }

   public function edit($id = null){
    $prospectModel = new EntiteModel();
    $prospect = $prospectModel->where('id', $id)->first();

    if (!$prospect) {
        return redirect()->to('/Prospects')->with('res', false)->with('message', 'Prospect introuvable');
    }

    // Transforme les clés en variables attendues par la view
    $data = [
        'id' => $prospect['id'],
        'nom' => $prospect['nom'],
        'prenom' => $prospect['prenom'],
        'adresse' => $prospect['adresse'],
        'cp' => $prospect['cp'],
        'ville' => $prospect['ville'],
        'tel_fixe' => $prospect['tel_fixe'],
        'mobile' => $prospect['mobile'],
        'email' => $prospect['email'],
        'web' => $prospect['web'],
        'notes' => $prospect['notes']
    ];

    return view('edit_prospect_view', $data);
}

 

    // update user data
    public function update(){
        $prospectModel = new EntiteModel();
        $this->session = service('session');
        $id = esc($this->request->getPost('id'));
        $data = [
            'id' => esc($this->request->getPost('id')),
            'nom' => esc($this->request->getPost('nom')),
            'prenom' => esc($this->request->getPost('prenom')),
            'adresse' => esc($this->request->getPost('adresse')),
            'cp' => esc($this->request->getPost('cp')),
            'ville' => esc($this->request->getPost('ville')),
            'tel_fixe'  => esc($this->request->getPost('tel_fixe')),
            'mobile'  => esc($this->request->getPost('mobile')),
            'email'  => esc($this->request->getPost('email')),
            'web'  => esc($this->request->getPost('web')),
            'notes'  => esc($this->request->getPost('notes'))
            
        ];

        $rule = [
            
            'nom' => 'required',
            
            
            

        ];


        $error = [   // Errors
            
            'nom' => [
                'required' => 'Vous devez préciser un nom.',
            ],
            
           

            ];

        if (! $this->validateData($data, $rule, $error)) {
            
           
            $this->session->setFlashdata(['res'=>false,'message'=>'Il ya des erreurs de saisie']);
            $data['errors'] = $this->validator->getErrors();
            return view('edit_prospect_view',$data);
            
        }
        $prospectModel->update($id,$data);
        $this->session->setFlashdata(['res'=>true,'message'=>'Le prospect a été sauvé avec succès.']);
        return $this->response->redirect(site_url('Prospects'));

        
    }
 
    // delete user
    public function delete($id = null){
        $prospectModel = new EntiteModel();

        $this->session = service('session');

        //$data['utilisateur'] = $utilisateurModel->where('id', $id)->delete($id);
        
        if ($prospectModel->where('id', $id)->delete($id)) 
        {
            
            $this->session->setFlashdata(['res'=>true,'message'=>'Le prospect a été supprimé ']);
            return $this->response->redirect(site_url("/Prospects"));
        }
        else
        {
            $this->session->setFlashdata(['res'=>false,'message'=>'Le prospect n\'a pas pu être supprimé ']);
            return $this->response->redirect(site_url("/Prospects"));

        }
        
        
    }
    
        // passer en client le prospect
        public function setToClient($id = null){
            $prospectModel = new EntiteModel();
    
            $this->session = service('session');
    
            //$data['utilisateur'] = $utilisateurModel->where('id', $id)->delete($id);
            
            if ($prospectModel->set('type', '2')
                                ->where('id', $id)
                                ->update()) 
            {
                
                $this->session->setFlashdata(['res'=>true,'message'=>'Le prospect a été passé en client ']);
                return $this->response->redirect(site_url("/Prospects/list"));
            }
            else
            {
                $this->session->setFlashdata(['res'=>false,'message'=>'Le prospect n\'a pas pu être passé en client ! ']);
                return $this->response->redirect(site_url("/Prospects/list"));
    
            }
            
            
        }

         // passer en client le prospect
         public function aContacter($id = null){
            
            $prospectModel = new EntiteModel();
    
            $this->session = service('session');
    
            //$data['utilisateur'] = $utilisateurModel->where('id', $id)->delete($id);
            
            if ($prospectModel->set('acontacter', 1)
                                ->where('id', $id)
                                ->update()) 
            {
                
                $this->session->setFlashdata(['res'=>true,'message'=>'Le prospect a été passé à \'A contacter\'']);
                return $this->response->redirect(site_url("/Prospects/list"));
            }
            else
            {
                $this->session->setFlashdata(['res'=>false,'message'=>'Le prospect n\'a pas pu être passé à \'A contacter\'']);
                return $this->response->redirect(site_url("/Prospects/list"));
    
            }
            
            
        }

        public function enrich()
{

    $id = $this->request->getPost('id');

    $model = new EntiteModel();

    $prospect = $model->find($id);

    if(!$prospect){
        return $this->response->setJSON(['status'=>false]);
    }

    $query = urlencode($prospect['nom'].' '.$prospect['ville']);

    // exemple recherche Bing
    $url = "https://api.bing.microsoft.com/v7.0/search?q=".$query;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);

    $result = curl_exec($ch);

    $data = json_decode($result,true);

    $site = $data['webPages']['value'][0]['url'] ?? null;

    $email = null;

    if($site){

        $html = @file_get_contents($site);

        preg_match('/[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}/i',$html,$match);

        $email = $match[0] ?? null;

    }

    $update = [
        'web'=>$site,
        'email'=>$email
    ];

    $model->update($id,$update);

    return $this->response->setJSON([
        'status'=>true,
        'site'=>$site,
        'email'=>$email
    ]);

}
}