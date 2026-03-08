<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Install extends Controller
{
    protected $lockFile = WRITEPATH . 'install.lock';

    public function index()
    {
        // Si déjà installé, redirige
        if (file_exists($this->lockFile)) {
            return redirect()->to('/Login')->with('error', 'StartCRM est déjà installé.');
        }

        return view('install_form');
    }

    // Test connexion AJAX
    public function testConnection()
    {
        $dbHost = $this->request->getPost('db_host');
        $dbUser = $this->request->getPost('db_user');
        $dbPass = $this->request->getPost('db_pass');

        if (!$dbHost || !$dbUser) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Host et utilisateur requis'
            ]);
        }

        $conn = @new \mysqli($dbHost, $dbUser, $dbPass);

        if ($conn->connect_error) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Impossible de se connecter au serveur MySQL : '.$conn->connect_error
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Connexion au serveur MySQL OK ! La base sera créée lors de l’installation.'
        ]);
    }

    // Exécution de l’installation
    public function run()
    {
        if (file_exists($this->lockFile)) {
            return redirect()->to('/Login')->with('error', 'StartCRM est déjà installé.');
        }

        // Récupère les paramètres du formulaire
        $dbHost = $this->request->getPost('db_host');
        $dbUser = $this->request->getPost('db_user');
        $dbPass = $this->request->getPost('db_pass');
        $dbName = $this->request->getPost('db_name');
        $baseURL = $this->request->getPost('base_url');

        $adminPrenom = $this->request->getPost('admin_prenom');
        $adminNom    = $this->request->getPost('admin_nom');
        $adminEmail  = $this->request->getPost('admin_email');
        $adminPass   = $this->request->getPost('admin_pass');

        // Vérification des champs
        if (!$dbHost || !$dbUser || !$dbName || !$baseURL ||
            !$adminPrenom || !$adminNom || !$adminEmail || !$adminPass) {
            return redirect()->back()->with('error', 'Tous les champs sont obligatoires.');
        }

        // 1️⃣ Connexion serveur MySQL (sans base)
        mysqli_report(MYSQLI_REPORT_OFF);
        $conn = @new \mysqli($dbHost, $dbUser, $dbPass);
        if ($conn->connect_error) {
            return redirect()->back()->with('error', 'Impossible de se connecter à MySQL : ' . $conn->connect_error);
        }

        // 2️⃣ Créer la base si elle n'existe pas
        if (!$conn->select_db($dbName)) {
            if (!$conn->query("CREATE DATABASE `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci")) {
                return redirect()->back()->with('error', 'Impossible de créer la base : ' . $conn->error);
            }
        }

        // 3️⃣ Sélectionner la base
        if (!$conn->select_db($dbName)) {
            return redirect()->back()->with('error', 'Impossible de sélectionner la base : ' . $conn->error);
        }

        // 4️⃣ Exécuter SQL
        $sqlFile = ROOTPATH . 'startcrm.sql';
        if (!file_exists($sqlFile)) {
            return redirect()->back()->with('error', 'Fichier SQL manquant : startcrm.sql');
        }

        $queries = explode(";\n", file_get_contents($sqlFile));
        foreach ($queries as $query) {
            $query = trim($query);
            if ($query) {
                if (!$conn->query($query)) {
                    return redirect()->back()->with('error', 'Erreur SQL : ' . $conn->error);
                }
            }
        }

        // 5️⃣ Créer .env avec app.baseURL correct
        $envFile = ROOTPATH . '.env';
        $envContent = <<<EOD
CI_ENVIRONMENT = development
app.baseURL = $baseURL
database.default.hostname = $dbHost
database.default.database = $dbName
database.default.username = $dbUser
database.default.password = $dbPass
EOD;

        if (!file_put_contents($envFile, $envContent)) {
            return redirect()->back()->with('error', 'Impossible de créer le fichier .env. Vérifiez les droits.');
        }

        // Mettre les bonnes permissions pour PHP
        chmod($envFile, 0644);

        // 6️⃣ Créer l’admin
        $passwordHash = password_hash($adminPass, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO t_utilisateurs (prenom, nom, email, mdp) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssss', $adminPrenom, $adminNom, $adminEmail, $passwordHash);
        if (!$stmt->execute()) {
            return redirect()->back()->with('error', 'Impossible de créer l\'utilisateur admin : ' . $stmt->error);
        }
        $stmt->close();

        // 7️⃣ Créer le lock
        if (!file_put_contents($this->lockFile, 'installed')) {
            return redirect()->back()->with('error', 'Impossible de créer le fichier install.lock');
        }

        return redirect()->to('/Login')->with('success', 'Installation terminée ! Vous pouvez maintenant vous connecter.');
    }
}