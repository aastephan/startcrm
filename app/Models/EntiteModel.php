<?php 
namespace App\Models;
use CodeIgniter\Model;

class EntiteModel extends Model
{
    protected $table = 't_entites';

    protected $primaryKey = 'id';

    protected $useSoftDeletes = true;
    
    protected $allowedFields = ['nom', 'prenom','adresse','cp','ville','tel_fixe','mobile','email','web','notes','contacte_via_form'];
    

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}