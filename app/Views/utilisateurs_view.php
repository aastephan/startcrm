<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Start CRM - Liste des utilisateurs</title>
    <!-- Favicons -->
  <link href="assets/img/favicon.ico" rel="icon">


    <!-- Custom fonts for this template-->
    <link href="<?php echo site_url('/assets/vendor/fontawesome-free/css/all.min.css')?>" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?php echo site_url('/assets/css/sb-admin-2.min.css')?>" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/vendor/datatables/datatables.min.css')?>">

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
                    <h1 class="h3 mb-2 text-gray-800">Liste des utilisateurs</h1>
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
                    <div class="d-flex justify-content-end">
                        <a href="<?php echo site_url('/Utilisateurs/new') ?>" class="btn btn-success mb-2">Nouvel utilisateur</a>
	                 </div>

                    
                    
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0" id="users-list">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nom</th>
                                            <th>Prénom</th>
                                            <th>EMail</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                            <th>ID</th>
                                            <th>Nom</th>
                                            <th>Prénom</th>
                                            <th>EMail</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php if($utilisateurs): ?>
                                    <?php foreach($utilisateurs as $utilisateur): ?>
                                    <tr>
                                       <td><?php echo $utilisateur['id']; ?></td>
                                       <td><?php echo $utilisateur['nom']; ?></td>
                                       <td><?php echo $utilisateur['prenom']; ?></td>
                                       <td><?php echo $utilisateur['email']; ?></td>
                                       <td>
                                       <a href="<?php echo base_url('/Utilisateurs/edit/'.$utilisateur['id']);?>" class="btn btn-primary btn-sm">Détail</a>
                                       <a href="<?php echo base_url('/Utilisateurs/delete/'.$utilisateur['id']);?>" class="btn btn-danger btn-sm confirmModalLink">Supprimer</a>
                                       </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                 </tbody>
                                </table>
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



    <div class="modal" tabindex="-1" id="confirmModal">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Confirmation suppression</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p>Etes-vous sûr(e) de vouloir supprimer cette ligne ?</p>
        </div>
        <div class="modal-footer">
        <a href="#" class="btn" id="confirmModalNo">Non</a>
        <a href="#" class="btn btn-primary" id="confirmModalYes">Oui</a>
        </div>
        </div>
    </div>
    </div>


<!-- Bootstrap core JavaScript-->
<script src="<?php echo site_url('/assets/vendor/jquery/jquery.min.js')?>"></script>
    <script src="<?php echo site_url('/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')?>"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?php echo site_url('/assets/vendor/jquery-easing/jquery.easing.min.js')?>"></script>
<!-- Custom scripts for all pages-->
<script src="<?php echo site_url('/assets/js/sb-admin-2.min.js')?>"></script>

<script type="text/javascript" src="<?php echo site_url('assets/vendor/datatables/datatables.min.js')?>"></script>
<script>

   
    $(document).ready( function () {
      $('#users-list').DataTable({
        language: {
            url: "<?php echo site_url('assets/vendor/datatables/fr-FR.json')?>"
        }
    }
      );
  } );

</script>

<script type="text/javascript">
   var theHREF;

$(".confirmModalLink").click(function(e) {
    e.preventDefault();
      theHREF = $(this).attr("href");
      $("#confirmModal").modal("show");
});

$("#confirmModalNo").click(function(e) {
    $("#confirmModal").modal("hide");
});

$("#confirmModalYes").click(function(e) {
    window.location.href = theHREF;
});
</script>

</body>

</html>