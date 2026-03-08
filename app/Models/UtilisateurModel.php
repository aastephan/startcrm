<?php 
namespace App\Models;
use CodeIgniter\Model;

class UtilisateurModel extends Model
{
    protected $table = 't_utilisateurs';

    protected $primaryKey = 'id';
    protected $useSoftDeletes = true;
    
    protected $allowedFields = ['nom', 'prenom','email','mdp','created_at','updated_at','deleted_at'];


    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';

    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}