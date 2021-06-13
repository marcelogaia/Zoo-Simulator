<?php
require_once "vendor/autoload.php";

$action = $_GET['action'] ?? 'empty';
Navarik\ZooController::render($action);