<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->setDefaultController('Accueil');
$routes->setDefaultMethod('index');

$routes->get('/', 'Accueil::index',['filter' => 'authVerif']);

//Menu Principal
$routes->get('Accueil', 'Accueil::index',['filter' => 'authVerif']);

// Login
$routes->get('Login', 'Login::index');
// Logout
$routes->get('Logout', 'Logout::index');

// Rediriger toute URL /Install vers /install
$routes->get('Install', function() {
    return redirect()->to('/install');
});

// Install
// Si le fichier install.lock n'existe pas, autoriser l'accès
if (!file_exists(ROOTPATH . 'install.lock')) { 
    $routes->get('Install', 'Install::index');    // majuscule I
    $routes->get('install', 'Install::index');    // aussi en minuscules
    $routes->post('install/run', 'Install::run');
}
$routes->post('install/test-connection', 'Install::testConnection');
//Auth
$routes->match(['get', 'post'], 'Login/Authentification', 'Login::Authentification');

// CRUD Utilisateurs Routes
$routes->get('Utilisateurs/list', 'Utilisateurs::list',['filter' => 'authVerif']);
$routes->get('Utilisateurs/new', 'Utilisateurs::new',['filter' => 'authVerif']);
$routes->get('Utilisateurs/create', 'Utilisateurs::create',['filter' => 'authVerif']);
$routes->post('Utilisateurs/create', 'Utilisateurs::create',['filter' => 'authVerif']);
$routes->get('Utilisateurs/edit/(:num)', 'Utilisateurs::edit/$1',['filter' => 'authVerif']);
$routes->post('Utilisateurs/update', 'Utilisateurs::update',['filter' => 'authVerif']);
$routes->get('Utilisateurs/delete/(:num)', 'Utilisateurs::delete/$1',['filter' => 'authVerif']);

// CRUD Prospects Routes
$routes->match(['get', 'post'],'Prospects', 'Prospects::index',['filter' => 'authVerif']);
$routes->match(['get', 'post'],'Prospects/list', 'Prospects::list',['filter' => 'authVerif']);
$routes->get('Prospects/new', 'Prospects::new',['filter' => 'authVerif']);
$routes->get('Prospects/create', 'Prospects::create',['filter' => 'authVerif']);
$routes->post('Prospects/create', 'Prospects::create',['filter' => 'authVerif']);
$routes->get('Prospects/edit/(:num)', 'Prospects::edit/$1',['filter' => 'authVerif']);
$routes->post('Prospects/update', 'Prospects::update',['filter' => 'authVerif']);
$routes->get('Prospects/delete/(:num)', 'Prospects::delete/$1',['filter' => 'authVerif']);
$routes->get('Import', 'Import::index',['filter' => 'authVerif']);
$routes->match(['get', 'post'], 'Import/importCSV', 'Import::importCSV');
$routes->post('Prospects/markContacted/(:num)', 'Prospects::markContacted/$1',['filter' => 'authVerif']);


// EXPORT

$routes->match(['get', 'post'], 'Export', 'Export::index',['filter' => 'authVerif']);
$routes->match(['get', 'post'], 'Export/csv', 'Export::csv',['filter' => 'authVerif']);



