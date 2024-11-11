<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once 'Core/db.php';
require_once 'Controllers/ModController.php';
require_once 'Controllers/ModderController.php';

$method = $_SERVER['REQUEST_METHOD'];
$requestUri = $_GET['REQUEST_URI'];
$request = explode('/', trim($requestUri, '/'));

$controller = new ModController();
$ModderController = new ModderController();

switch ($method) {
    case 'GET':
        if (isset($request[0]) && $request[0] == 'mods') {
            if (isset($request[1])) {
                $controller->getMod(intval($request[1]));
            } else {
                $controller->getMods();
            }
        }
        else if (isset($request[0]) && $request[0] == 'modders') {
            if (isset($request[1])) {
                $ModderController->getModder(intval($request[1]));
            } else {
                $ModderController->getModders();
            }
        }
        break;

    case 'POST':
        if (isset($request[0]) && $request[0] == 'mods') {
            $controller->createMod();
        } else if (isset($request[0]) && $request[0] == 'signup') {
            $ModderController->createModder();
        } else if (isset($request[0]) && $request[0] == 'signin') {
            $ModderController->login();
        }
        break;

    case 'PUT':
        if (isset($request[0]) && $request[0] == 'mods' && isset($request[1])) {
            $controller->updateMod(intval($request[1]));
        } else if (isset($request[0]) && $request[0] == 'modders' && isset($request[1])) {
            $ModderController->updateModder(intval($request[1]));
        }
        break;

    case 'DELETE':
        if (isset($request[0]) && $request[0] == 'mods' && isset($request[1])) {
            $controller->deleteMod(intval($request[1]));
        } else if (isset($request[0]) && $request[0] == 'modders' && isset($request[1])) {
            $ModderController->deleteModder(intval($request[1]));
        }
        break;

    case 'OPTIONS':
        // Ignore OPTIONS for preflighted requests
        break;

    default:
        header("HTTP/1.1 405 Method Not Allowed");
        break;
}