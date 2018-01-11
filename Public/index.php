<?php
/**
 * L'autoloader est appelé ici, pour qu'il fasse son travail.
 * Rappel : la class Autoloader est dans "projet5/Autoloading"
 */
use App\Autoloading\Autoloader;
use App\Routing\Route;
require '../App/Autoloading/Autoloader.php';

Autoloader::register();
session_start();
$siteweb = new Route();
$siteweb->start();


