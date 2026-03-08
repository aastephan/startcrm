<?php 

namespace App\Controllers; 
use App\Models\EntiteModel; 
use CodeIgniter\Controller;

  

class Import extends Controller
{
    public function index()
    {
        
        $this->session = service('session');

        $data = [];

        return view('import_view',$data);

    } 

    public function importCSV()
{
    $this->session = service('session');
    $data = [];

    $input = $this->validate([
        'file' => 'uploaded[file]|max_size[file,2048]|ext_in[file,csv]'
    ]);

    if (!$input) {
        $data['validation'] = $this->validator;
        $this->session->setFlashdata(['res'=>false,'message'=>'Le fichier sélectionné n\'est pas conforme']);
        return view('import_view', $data);
    }

    $file = $this->request->getFile('file');

    if ($file && $file->isValid() && !$file->hasMoved()) {

        $newName = $file->getRandomName();
        $path = WRITEPATH . 'uploads/csvfile/';

        $file->move($path, $newName);

        $handle = fopen($path . $newName, "r");

        $i = 0;
        $numberOfFields = 7;

        $csvArr = [];

        while (($filedata = fgetcsv($handle, 1000, ";")) !== FALSE) {

            $num = count($filedata);

            if ($i > 0 && $num == $numberOfFields) {

                $adresse = $filedata[1];

                // au cas oùcp et ville sont dans la colonne adresse
                $cp = '';
                $ville = '';

                if (($filedata[2] == "") && ($filedata[3] == ""))

                
                if (preg_match('/\b(\d{5})\s+(.+)$/', $adresse, $matches)) {
                    $cp = $matches[1];
                    $ville = $matches[2];
                }
                else{
                    $cp = $filedata[2];
                    $ville = $filedata[3];
                }

                $csvArr[] = [
                    'nom'     => $filedata[0],
                    'adresse' => $adresse,
                    'cp'      => $cp,
                    'ville'   => $ville,
                    'tel'     => $filedata[4],
                    'email'   => $filedata[5],
                    'web'     => $filedata[6],
                ];
                            }

            $i++;
        }

        fclose($handle);

        $count = 0;

        $prospectModel = new EntiteModel();

        foreach ($csvArr as $prospect) {
            if ($prospectModel->insert($prospect)) {
                $count++;
            }
        }

        $this->session->setFlashdata([
            'res'=>true,
            'message'=>$count.' prospects ont été importés.'
        ]);

        return view('import_view', $data);
    }

    $this->session->setFlashdata([
        'res'=>false,
        'message'=>'L\'importation a échoué'
    ]);

    return view('import_view', $data);
}
  
   
}
