public function run()
{
    // Bloquer si déjà installé
    if (file_exists(WRITEPATH . 'install.lock')) {
        return redirect()->to('/')->with('error', 'StartCRM est déjà installé.');
    }

    // Récupération des paramètres du formulaire
    $dbHost = $this->request->getPost('db_host');
    $dbUser = $this->request->getPost('db_user');
    $dbPass = $this->request->getPost('db_pass');
    $dbName = $this->request->getPost('db_name');
    $baseURL = $this->request->getPost('base_url');

    $adminPrenom = $this->request->getPost('admin_prenom');
    $adminNom = $this->request->getPost('admin_nom');
    $adminEmail = $this->request->getPost('admin_email');
    $adminPass = $this->request->getPost('admin_pass');

    // Vérification des champs obligatoires
    if (!$dbHost || !$dbUser || !$dbName || !$baseURL ||
        !$adminPrenom || !$adminNom || !$adminEmail || !$adminPass) {
        return redirect()->back()->with('error', 'Tous les champs sont obligatoires.');
    }

    // Connexion serveur MySQL (sans passer la base)
    mysqli_report(MYSQLI_REPORT_OFF);
    $conn = @new \mysqli($dbHost, $dbUser, $dbPass);
    if ($conn->connect_error) {
        return redirect()->back()->with('error', 'Impossible de se connecter à MySQL : ' . $conn->connect_error);
    }

    // Créer la base si elle n'existe pas
    if (!$conn->select_db($dbName)) {
        if (!$conn->query("CREATE DATABASE `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci")) {
            return redirect()->back()->with('error', 'Impossible de créer la base : ' . $conn->error);
        }
    }

    // Sélectionner la base
    if (!$conn->select_db($dbName)) {
        return redirect()->back()->with('error', 'Impossible de sélectionner la base : ' . $conn->error);
    }

    // Exécuter le fichier SQL
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

    // Créer le fichier .env dans writable/ pour éviter les problèmes de permissions
    $envContent = "
CI_ENVIRONMENT = development
database.default.hostname = $dbHost
database.default.database = $dbName
database.default.username = $dbUser
database.default.password = $dbPass
baseURL = $baseURL
";
    $envFile = WRITEPATH . '.env';
    if (!file_put_contents($envFile, $envContent)) {
        return redirect()->back()->with('error', 'Impossible de créer le fichier .env dans writable/. Vérifiez les droits.');
    }

    // Créer l’admin
    $passwordHash = password_hash($adminPass, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO t_utilisateurs (prenom, nom, email, mdp) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('ssss', $adminPrenom, $adminNom, $adminEmail, $passwordHash);

    if (!$stmt->execute()) {
        return redirect()->back()->with('error', 'Impossible de créer l\'utilisateur admin : ' . $stmt->error);
    }
    $stmt->close();

    // Créer le lock pour bloquer l’accès à l’install
    $lockFile = WRITEPATH . 'install.lock';
    if (!file_put_contents($lockFile, 'installed')) {
        return redirect()->back()->with('error', 'Impossible de créer le fichier install.lock dans writable/.');
    }

    return redirect()->to('/')->with('success', 'Installation terminée ! Vous pouvez maintenant vous connecter.');
}