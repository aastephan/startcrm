<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Start CRM - Nouvel utilisateur</title>
    <!-- Favicons -->
  <link href="assets/img/favicon.ico" rel="icon">

    <!-- Custom fonts for this template-->
    <link href="<?php echo site_url('/assets/vendor/fontawesome-free/css/all.min.css')?>" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?php echo site_url('/assets/css/sb-admin-2.min.css')?>" rel="stylesheet">

    <style>
    
    .error {
      display: block;
      padding-top: 5px;
      font-size: 14px;
      color: red;
      width:100%;
    }
  </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

    <?php include "sidebar.php" ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

               <?php include "topbar.php" ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Nouvel utilisateur</h1>
                        
                    </div>
                    <?php

                    $this->session = service('session');
                    if ($this->session->getFlashdata('res')!==null)
                    {
                        if ($this->session->getFlashdata('res') == false)
                        {
                        ?>
                        <div class="alert alert-danger" role="alert">
                        <?php echo $this->session->getFlashdata('message');?>
                        </div>
                        <?php } else { ?>
                        <div class="alert alert-success" role="alert">
                        <?php echo $this->session->getFlashdata('message'); ?>                          
                        </div>
                        <?php } ?>
                  
                          <?php if (isset($errors)) {
                          ?>  
                          
                          <ul style="color:red;">
                              <?php foreach ($errors as $error): ?>
                                  <li><?= esc($error) ?></li>
                              <?php endforeach ?>
                          </ul>

                      <?php }
                      } 
                      ?>
                  

                    <!-- Content Row -->
                    <div class="row">
                      
                        <div class="col-xl-8 col-lg-8 col-md-6 sm-12">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                  <form method="post" id="frmCreate" name="add_create" action="<?php echo site_url('/Utilisateurs/create')?>">
                                  <?= csrf_field() ?>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                          <button type="submit" class="btn btn-primary">Créer</button>
                                          <a class="btn btn-secondary" href="<?php echo site_url('/Utilisateurs/list')?>" role="button">Retour</a>
                                          <br>
                                          <br>
                                        </div>
                                    </div>
                                      
                                        
                                          <div class="row">
                                            <div class="col-lg-8 col-sm-12">

                                                <div class="form-group">
                                                    <label for="nom" class="form-label">Nom</label>
                                                    <input type="text" class="form-control" id="nom" name="nom" value="<?= $nom ?>">                                                    
                                                </div>
                                                <div class="form-group">
                                                    <label for="prenom" class="form-label">Prénom</label>
                                                    <input type="text" class="form-control" id="prenom" name="prenom" value="<?= $prenom ?>">
                                                    
                                                </div>
                                                <div class="form-group">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="email" name="email" value="<?= $email ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="mdp" class="form-label">Mot de passe</label>
                                                    <input type="password" class="form-control" id="mdp" name="mdp" value="<?= $mdp ?>">
                                                </div>
                                                                                          
                                            </div>
                                        
                                          </div>
                                        
                                   
                                </div>
                                </form>
                            </div>
                        </div>

        

 
                    </div>

                  

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

           <?php include "footer.php" ?>

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?php echo site_url('/assets/vendor/jquery/jquery.min.js')?>"></script>
    <script src="<?php echo site_url('/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')?>"></script>
    <!-- jquery validate plugin -->
    <script src="<?php echo site_url('/assets/vendor/jquery-validate/jquery.validate.min.js')?>"></script>
    <script src="<?php echo site_url('/assets/vendor/jquery-validate/additional-methods.min.js')?>"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?php echo site_url('/assets/vendor/jquery-easing/jquery.easing.min.js')?>"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?php echo site_url('/assets/js/sb-admin-2.min.js')?>"></script>

    <script>
        jQuery.validator.addMethod("verifMdp", function(value, element) {
        // allow any non-whitespace characters as the host part
        return this.optional( element ) || /^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*\W)(?!.* ).{8,16}$/.test( value );
        }, 'Entrez un mot de passe respectant ces conditions : ');

    if ($("#frmCreate").length > 0) {
      $("#frmCreate").validate({
        rules: {
          nom: {
            required: true,
          },
          prenom: {
            required: true,
          },
          email: {
            required: true,
            maxlength: 60,
            email: true,
          },
          mdp: {
            required: true,
            minlength: 8,
            verifMdp: true,
          },
        },
        messages: {
          nom: {
            required: "Veuillez préciser le nom.",
          },
          prenom: {
            required: "Veuillez préciser le prénom.",
          },
          email: {
            required: "Veuillez préciser l'email.",
            email: "Veuiller entrer une adresse email valide.",
            maxlength: "L'email ne peut pas dépasser 60 caractères",
          },
          mdp: {
            required: "Veuillez préciser un mot de passe",
            minlength: "Le mot de passe doit avoir 8caractères minimum",
            verifMdp: "Le mot de passe doit contenir un chiffre une lettre minuscule une lettre majuscule et un caractère spécial",
          },

        },
      })
    }
  </script>

    


</body>

</html>