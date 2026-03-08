<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Config\Database;

class Export extends Controller
{

    public function index()
    {
        return view('export_view');
    }

 public function csv()
{
    $type = $this->request->getPost('type');

    $db = \Config\Database::connect();
    $builder = $db->table('t_entites');

    if ($type == 'email') {
        $builder->where('email IS NOT NULL');
        $builder->where("TRIM(email) !=", "");
    }

    if ($type == 'contact_form') {
        $builder->where('contacte_via_form', 1);
    }

    $results = $builder->get()->getResultArray();

    $filename = "export_prospects_" . date('Y-m-d') . ".csv";

    $csv = '';

    if (!empty($results)) {

        // entêtes
        $csv .= implode(';', array_keys($results[0])) . "\n";

        foreach ($results as $row) {
            $csv .= implode(';', $row) . "\n";
        }
    }

    return $this->response
        ->setHeader('Content-Type', 'text/csv; charset=UTF-8')
        ->setHeader('Content-Disposition', 'attachment; filename="'.$filename.'"')
        ->setBody($csv);
}
}