<?php
namespace Navarik\Zoo;
require_once "vendor/autoload.php";

// Simplest Router.
$action = $_GET['action'] ?? '';
switch( $action ) {
    case 'start':
        ZooController::startZoo();
        break;
    case 'age':
        ZooController::passTime();
        break;
    case 'feed':
        ZooController::feedAnimals();
        break;
    case 'close':
        ZooController::closeZoo();
        break;
    default:
        ZooController::render();
        break;
}

if( ! empty( $action ) ) {
    header('Location: /'); exit;
}