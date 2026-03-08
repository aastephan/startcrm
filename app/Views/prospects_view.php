<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Start CRM - Liste des prospects</title>
    <!-- Favicons -->
  <link href="assets/img/favicon.ico" rel="icon">


    <!-- Custom fonts for this template-->
    <link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('assets/css/sb-admin-2.min.css') ?>" rel="stylesheet">

    <!-- Custom styles for this page -->
    
    <link href="<?= base_url('assets/vendor/datatables/datatables.min.css') ?>" rel="stylesheet">

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
                    <h1 class="h3 mb-2 text-gray-800">Liste des prospects</h1>
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
                        
                        <div class="form-group">
                        
                            <a href="<?= base_url('Prospects/new') ?>" class="btn btn-success mb-2">Nouveau prospect</a>
                        </div>
	                </div>
                    <div class="row">
                        <div class="col-3">
                            <form method="post" id="frmFilter" name="frmFilter" action="/Prospects/list">
                            <?= csrf_field() ?>
                               
                        </div>
                        <div class="col-3">
                            
                            
                                <div class="form-group">
                                    
                                    <select class="form-control" id="selFilter" name="selFilter" aria-label="selFilter" >
                                                                                                                        
                                        
                                        <option value="0">A prospecter </option>                                    
                                        <option value="1">Avec mails</option>                                    
                                        <option value="2">Contactés</option>                                    
            
                                    </select>  
                                </div>
                        </div>

                        
                    </form>
                    </div>    
                   

                                    
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="table-prospects" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nom</th>
                                            <th>Ville</th>
                                            <th>Email</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nom</th>
                                            <th>Ville</th>
                                            <th>Email</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody></tbody>
                                </table>
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
     <script src="<?= base_url('assets/vendor/jquery/jquery.min.js') ?>"></script>
    
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <!-- jquery validate plugin -->
    
    <script src="<?= base_url('assets/vendor/jquery-validate/jquery.validate.min.js') ?>"></script>
    
    <script src="<?= base_url('assets/vendor/jquery-validate/additional-methods.min.js') ?>"></script>

    <!-- Core plugin JavaScript-->
    
    <script src="<?= base_url('assets/vendor/jquery-easing/jquery.easing.min.js') ?>"></script>

    <!-- Custom scripts for all pages-->
    
    <script src="<?= base_url('assets/js/sb-admin-2.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/datatables/datatables.min.js') ?>"></script>

<script>

   /*
    $(document).ready( function () {
      $('#table-list').DataTable({
        language: {
            url: "assets/vendor/datatables/fr-FR.json"
        }
    }
      );
  } );
   */

</script>

<script>
$(document).ready(function () {
    var table = $('#table-prospects').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "Prospects/list",
            type: "POST",
           data: function(d) {
                // Récupère le champ hidden généré par csrf_field()
                var csrfName = $('#frmFilter input[type="hidden"]').attr('name');
                var csrfHash = $('#frmFilter input[type="hidden"]').val();
                d[csrfName] = csrfHash;

                // Valeur du filtre
                d['selFilter'] = $('#selFilter').val();
            }
        },
        language: {
            url: "assets/vendor/datatables/fr-FR.json"
        }
    });

    // reload DataTable si filtre change
    $('#selFilter').change(function() {
        table.ajax.reload();
    });

    // mettre à jour le token après chaque requête AJAX réussie
    $('#table-prospects').on('xhr.dt', function (e, settings, json, xhr) {
        if(json.csrfHash){
            $('#frmFilter input[type="hidden"]').val(json.csrfHash);
        }
    });
});
</script>
<script>
$(document).on('click', '.btn-contacted', function() {
    var id = $(this).data('id');
    var button = $(this);

    // Récupérer le token CSRF actuel
    var csrfName = $('#frmFilter input[type="hidden"]').attr('name');
    var csrfHash = $('#frmFilter input[type="hidden"]').val();
    var data = {};
    data[csrfName] = csrfHash;

    $.ajax({
        url: '/Prospects/markContacted/' + id,
        type: 'POST',
        data: data,
        dataType: 'json',
        success: function(response) {
            // Mettre à jour le token CSRF pour la prochaine requête
            if(response.csrfHash){
                $('#frmFilter input[type="hidden"]').val(response.csrfHash);
            }
            if(response.success){
                // Changer le bouton pour indiquer que c'est fait
                button.removeClass('btn-success').addClass('btn-secondary').text('Contacté').prop('disabled', true);
                // Optional : reload DataTable
                $('#table-prospects').DataTable().ajax.reload(null, false);
            } else {
                alert(response.message);
            }
        },
        error: function() {
            alert('Erreur AJAX');
        }
    });
});
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

<script>
$(document).on("click",".enrich-prospect",function(){

    let id = $(this).data("id");
    let button = $(this);

    button.prop("disabled", true);
    button.text("Recherche...");

    $.ajax({
        url: "/prospects/enrich",
        type: "POST",
        data: {id:id},
        dataType: "json",
        success:function(res){

            if(res.status){

                button.removeClass("btn-primary")
                      .addClass("btn-success")
                      .text("✔ Enrichi");

                // option : recharger la table
                $('#datatable').DataTable().ajax.reload(null,false);

            }else{

                button.prop("disabled", false);
                button.text("Erreur");

            }

        },
        error:function(){
            button.prop("disabled", false);
            button.text("Erreur serveur");
        }

    });

});
    </script>

</body>

</html>