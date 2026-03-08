        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('Accueil') ?>">                
                <div class="sidebar-brand-text mx-3">Start CRM</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="<?= base_url('Accueil') ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Menu principal</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Prospects
            </div>
             <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('Prospects') ?>">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Liste des prospects</span>
                </a>
            </li>
             <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('Prospects/new') ?>">
                    <i class="fas fa-fw fa-star"></i>
                    <span>Nouveau prospect</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('Import') ?>">
                    <i class="fas fa-fw fa-download"></i>
                    <span>Importer des prospects</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('Export') ?>">
                    <i class="fas fa-fw fa-download"></i>
                    <span>Exporter des prospects</span></a>
            </li>
              <!-- Divider -->
            <hr class="sidebar-divider">
             <li class="nav-item">
                <a class="nav-link" href="<?= site_url('Utilisateurs/list') ?>">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Gestion des utilisateurs</span></a>
            </li>




            
           
              
           

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Sidebar Message -->
            <div class="sidebar-card d-none d-lg-flex">
                <img class="sidebar-card-illustration mb-2" src="<?php echo site_url('/assets/img/undraw_rocket.svg')?>" alt="...">
                <p class="text-center mb-2"><strong>Start CRM</strong> est un outil gratuit !</p>
                <a class="btn btn-success btn-sm" href="http://startcrm.online.fr" target="_blank">Voir le site</a>
            </div>

        </ul>
        <!-- End of Sidebar -->