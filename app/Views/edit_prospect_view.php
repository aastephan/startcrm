<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Start CRM - Nouveau prospect</title>
    <!-- Favicons -->
  <link href="assets/img/favicon.ico" rel="icon">

    <!-- Custom fonts for this template-->
    
    <link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    
    <link href="<?= base_url('assets/css/sb-admin-2.min.css') ?>" rel="stylesheet">
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
                        <h1 class="h3 mb-0 text-gray-800">Détail prospect</h1>
                        
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
                      
                        <div class="col-xl-10 col-lg-10 col-md-6 sm-12">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                  <form method="post" id="frmCreate" name="add_create" action="<?= base_url('Prospects/update') ?>">
                                  <?= csrf_field() ?>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                          <button type="submit" class="btn btn-primary">Sauver</button>
                                          <a class="btn btn-secondary" href="<?= base_url('Prospects') ?>" role="button">Retour</a>
                                        
                                        </div>
                                    </div>
                                      
                                        
<div class="row">

    <div class="col-lg-6 col-sm-12">

        <div class="form-group">
            <label for="id" class="form-label">ID</label>
            <input type="text" class="form-control" id="id" name="id" value="<?php echo $id ?>" readonly>
        </div>



        <div class="form-group">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom" value="<?= $nom ?>">
        </div>

        <div class="form-group" id="divPrenom">
            <label for="prenom" class="form-label">Prénom</label>
            <input type="text" class="form-control" id="prenom" name="prenom" value="<?= $prenom ?>">
        </div>

        <div class="form-group">
            <label for="adresse" class="form-label">Adresse</label>
            <input type="text" class="form-control" id="adresse" name="adresse" value="<?= $adresse ?>">
        </div>

        <div class="form-group">
            <label for="cp" class="form-label">Code Postal</label>
            <input type="text" class="form-control" id="cp" name="cp" value="<?= $cp ?>">
        </div>

        <div class="form-group">
            <label for="ville" class="form-label">Ville</label>
            <input type="text" class="form-control" id="ville" name="ville" value="<?= $ville ?>">
        </div>

    </div>

    <div class="col-lg-6 col-sm-12">

        <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= $email ?>">
        </div>

        <div class="form-group">
            <label for="tel_fixe" class="form-label">Téléphone</label>
            <input type="text" class="form-control" id="tel_fixe" name="tel_fixe" value="<?= $tel_fixe ?>">
        </div>

        <div class="form-group">
            <label for="mobile" class="form-label">Mobile</label>
            <input type="text" class="form-control" id="mobile" name="mobile" value="<?= $mobile ?>">
        </div>

        <div class="form-group">
            <label for="web" class="form-label">Site Web</label>
            <input type="text" class="form-control" id="web" name="web" value="<?= $web ?>">
        </div>

    </div>

    <div class="col-lg-12 col-sm-12">
        <div class="form-group">
            <label for="notes" class="form-label">Notes</label>
            <textarea class="form-control" id="notes" name="notes" rows="10"><?= $notes ?></textarea>
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



    <div class="modal" tabindex="-1" id="confirmModalSetToClient">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Confirmation passer en client</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p>Etes-vous sûr(e) de vouloir passer ce prospect en client ?</p>
        </div>
        <div class="modal-footer">
        <a href="#" class="btn" id="confirmModalNo">Non</a>
        <a href="#" class="btn btn-primary" id="confirmModalYes">Oui</a>
        </div>
        </div>
    </div>
    </div>


    <!-- Bootstrap core JavaScript-->
    
    <script src="<?= base_url('assets/vendor/jquery/jquery.min.js') ?>"></script>
    
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <!-- jquery validate plugin -->
    
    <script src="<?= base_url('assets/vendor/jquery-validate/jquery.validate.min.js') ?>"></script>
    
    <script src="<?= base_url('assets/vendor/jquery-validate/additional-methods.min.js') ?>"></script>

    <!-- Core plugin JavaScript-->
    
    <script src="<?= base_url('assets/vendor/jquery-easing/jquery.easing.min.js') ?>"></script>

    <!-- Custom scripts for all pages-->
    
    <script src="<?= base_url('assets/js/sb-admin-2.min.js') ?>"></script>

    <script>
        jQuery.validator.addMethod("verifMdp", function(value, element) {
        // allow any non-whitespace characters as the host part
        return this.optional( element ) || /^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*\W)(?!.* ).{8,16}$/.test( value );
        }, 'Entrez un mot de passe respectant ces conditions : ');

    if ($("#frmCreate").length > 0) {
      $("#frmCreate").validate({
        rules: {
            profil: {
            min: 1,
          },  
          nom: {
            required: true,
          },
         
          
          
        },
        messages: {
            profil: {
            min: "Veuillez préciser si c'est une société ou un particulier.",
          },
          nom: {
            required: "Veuillez préciser le nom.",
          },
          
          

        },
      })
    }
  </script>

  <script>
    $("#profil").change(function(){

    if ($("#profil").val() == 2) 
        $("#divPrenom").fadeOut();
    else
        $("#divPrenom").fadeIn();
    });

    $(document).ready(function(){
        if ($("#profil").val() == 2) 
            $("#divPrenom").fadeOut();
        else
            $("#divPrenom").fadeIn();
    });
    
  </script>

<script type="text/javascript">
   var theHREF;

$(".confirmModalSetToClient").click(function(e) {
    e.preventDefault();
      theHREF = $(this).attr("href");
      $("#confirmModalSetToClient").modal("show");
});

$("#confirmModalNo").click(function(e) {
    $("#confirmModalSetToClient").modal("hide");
});

$("#confirmModalYes").click(function(e) {
    window.location.href = theHREF;
});
</script>



    


</body>

</html>