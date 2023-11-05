<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->group("api", function ($routes) {
    $routes->get("/", "Home::index");
    $routes->post("register", "RegisterController::index");
    $routes->post("login", "LoginController::index");
    $routes->post("authme", "UserController::index", ['filter' => 'authFilter']);
    $routes->post("update-profile", "UserController::update_profile", ['filter' => 'authFilter']);
    $routes->post("absensi", "AbsensiController::store_absen", ['filter' => 'authFilter']);
    $routes->post("history-absensi", "AbsensiController::history", ['filter' => 'authFilter']);
});