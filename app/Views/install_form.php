<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Installation StartCRM</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body class="p-5 bg-light">
<div class="container">
    

    <div class="card shadow-sm">
        <div class="card-body">
            <h1 class="card-title mb-4">Installation de StartCRM</h1>

            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <form method="post" action="install/run">
                <?= csrf_field() ?>



                <!-- Paramètres MySQL -->
                <h4 class="mb-3">Paramètres MySQL</h4>
                <div class="mb-3">
                    <label class="form-label">Serveur MySQL</label>
                    <input type="text" name="db_host" class="form-control" value="localhost" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Utilisateur MySQL</label>
                    <input type="text" name="db_user" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mot de passe MySQL</label>
                    <input type="password" name="db_pass" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Nom de la base</label>
                    <input type="text" name="db_name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <button type="button" id="testDbBtn" class="btn btn-info">Tester la connexion MySQL</button>
                    <span id="dbTestResult" class="ms-2"></span>
                </div>

                <!-- Paramètres StartCRM -->
                <h4 class="mb-3 mt-4">Paramètres StartCRM</h4>
                <div class="mb-3">
                    <label class="form-label">URL de la web app</label>
                    <!--<input type="text" name="base_url" class="form-control" value="" required>-->
                    <?php 
                    $autoURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")
                            . "://$_SERVER[HTTP_HOST]" 
                            . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/';
                    ?>
                    <input type="text" name="base_url" class="form-control" value="<?= $autoURL ?>" required>
                </div>

                <!-- Admin -->
                <h4 class="mb-3 mt-4">Compte Admin</h4>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Prénom</label>
                        <input type="text" name="admin_prenom" class="form-control" placeholder="Prénom" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nom</label>
                        <input type="text" name="admin_nom" class="form-control" placeholder="Nom" required>
                    </div>
                </div>
                <div class="mb-3 mt-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="admin_email" class="form-control" placeholder="admin@example.com" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" name="admin_pass" class="form-control" placeholder="Mot de passe" required>
                </div>

                <hr>

                <button type="submit" class="btn btn-primary w-100">Installer StartCRM</button>
            </form>
        </div>
    </div>
</div>

<script>
$('#testDbBtn').click(function() {
    $('#dbTestResult').html('Test en cours...');
    $.ajax({
        url: 'install/test-connection',
        type: 'POST',
        data: {
            db_host: $('input[name=db_host]').val(),
            db_user: $('input[name=db_user]').val(),
            db_pass: $('input[name=db_pass]').val(),
            db_name: $('input[name=db_name]').val()
        },
        success: function(response) {
            if (response.status === 'success') {
                $('#dbTestResult').html('<span class="text-success">'+response.message+'</span>');
            } else {
                $('#dbTestResult').html('<span class="text-danger">'+response.message+'</span>');
            }
        },
        error: function() {
            $('#dbTestResult').html('<span class="text-danger">Erreur AJAX</span>');
        }
    });
});
</script>
</body>
</html>