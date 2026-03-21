<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Start CRM - Export de prospects</title>
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
                        <h1 class="h3 mb-0 text-gray-800">Exportation de prospects</h1>
                        
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
                                  
                                      
                                        
                                          <div class="row">
                      
                                     
                                      <div class="container mt-4">

                                        <h3>Export CSV des prospects</h3>

                                        <form method="post" action="<?= site_url('Export/csv') ?>">

                                        <div class="form-group">

                                        <label>Type d'export</label>

                                        <select name="type" class="form-control">

                                        <option value="all">Tous les prospects</option>
                                        <option value="email">Emails remplis</option>
                                        <option value="contact_form">Contactés via formulaire</option>

                                        </select>

                                        </div>

                                        <br>

                                        <button type="submit" class="btn btn-primary">
                                        Exporter CSV
                                        </button>

                                        </form>

                                        </div>
                                        
                                          </div>
                                        
                                   
                                </div>
                                
                            </div>
                        </div>

        

 
                    </div>

                    <div class="row">
                      
                        <div class="col-xl-10 col-lg-10 col-md-6 sm-12">
                            <?php 
                            if (isset($csv))
                            {
                                echo "ya des données";
                                $i=0;
                                var_dump($csv);
                                foreach($csv as $ligne){
                                    echo "LIGNE";
                                    echo $ligne['nom'];
                                    //echo $ligne[0]['nom'];
                                    //echo $ligne[0]['prenom'];
                                }
                            }

                            ?>
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
    $("#profil").change(function(){

    if ($("#profil").val() == 2) 
        $("#divPrenom").fadeOut();
    else
        $("#divPrenom").fadeIn();
    });

  </script>



    


</body>

</html>